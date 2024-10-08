import cv2
import tkinter as tk
from tkinter import messagebox
from datetime import datetime
import imutils
import numpy as np
import mysql.connector
from PIL import Image
from skimage.metrics import structural_similarity as compare_ssim
import sys
import os
 
#rtsp_link = "rtsp://888888:@103.1.101.205:566/cam/realmonitor?channel=6&subtype=0"
#rtsp_link = "rtsp://admin:123456@192.168.15.105:8080/h264_aac.sdp"
rtsp_link = "http://admin:123456@192.168.137.76:8080/video"
timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
storepath = "C:\\laragon\\www\\diffshade\\public\\store"
# MySQL connection details
db_config = {
    'user': 'root',
    'password': '',
    'host': 'localhost',
    'database': 'diffshade'
}

# Function to save data to the MySQL database
def save_to_database(jobcard_no, captured_imagename, output_filename, accuracy, created_by):
    try:
        # Connect to the database
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor() 
        
        query = "Insert into diffshadedetail (jobcard_no, uploaded_image, output_image, accuracy, created_by) values (%s, %s, %s,%s,%s)"
        values = (jobcard_no,captured_imagename,output_filename,accuracy,created_by)
        # Execute the query and commit the transaction
        cursor.execute(query, values)
        conn.commit()
        #print("Data saved successfully")

    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        cursor.close()
        conn.close()

def capture_image(jobcard_no):    
    cap = cv2.VideoCapture(rtsp_link)
    ret, frame = cap.read()
    image_path = None
    if ret:
        # Resize the frame to the desired width and height
        desired_width = 4000  # Set your desired width
        desired_height = 2250  # Set your desired height
        resized_frame = cv2.resize(frame, (desired_width, desired_height))        
        
        # Generate a filename with the current date and time
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        image_path = f"{storepath}\\{jobcard_no}\\{timestamp}.jpg"                      
        # Ensure directory exists
        os.makedirs(os.path.dirname(image_path), exist_ok=True)

        cv2.imwrite(image_path, resized_frame)
        #print(f"Image captured successfully! Saved at { image_path}")        
    else:        
        print(f"Failed to capture image.")
    cap.release()
    return image_path

def resize_and_pad(img, size, pad_color=0):
    h, w = img.shape[:2]
    sh, sw = size

    # Scale and pad the image
    aspect = w / h
    if aspect > 1:
        new_w = sw
        new_h = int(new_w / aspect)
        pad_vert = (sh - new_h) / 2
        pad_top, pad_bot = int(np.floor(pad_vert)), int(np.ceil(pad_vert))
        pad_left, pad_right = 0, 0
    elif aspect < 1:
        new_h = sh
        new_w = int(new_h * aspect)
        pad_horz = (sw - new_w) / 2
        pad_left, pad_right = int(np.floor(pad_horz)), int(np.ceil(pad_horz))
        pad_top, pad_bot = 0, 0
    else:
        new_h, new_w = sh, sw
        pad_top, pad_bot, pad_left, pad_right = 0, 0, 0, 0

    img = cv2.resize(img, (new_w, new_h), interpolation=cv2.INTER_AREA)
    
    if isinstance(pad_color, tuple) and len(pad_color) == 3:
        img = cv2.copyMakeBorder(img, pad_top, pad_bot, pad_left, pad_right,borderType=cv2.BORDER_CONSTANT, value=pad_color)
    else:
        img = cv2.copyMakeBorder(img, pad_top, pad_bot, pad_left, pad_right,borderType=cv2.BORDER_CONSTANT, value=[pad_color])

    return img

def main(jobcard_no, original_image, created_by):
       
    original_image_path = f"{storepath}\\{jobcard_no}\\{original_image}"
    captured_image_path = capture_image(jobcard_no) 

    if not captured_image_path:
        print("Image capture failed, aborting.")
        return

    img1 = cv2.imread(original_image_path)  # original
    img2 = cv2.imread(captured_image_path)  # captured image

    #img1 = imutils.resize(img1, height=500)
    #img2 = imutils.resize(img2, height=500)
    # Resize and pad images to the same dimensions
    size = (max(img1.shape[0], img2.shape[0]), max(img1.shape[1], img2.shape[1]))

    img1 = resize_and_pad(img1, size)
    img2 = resize_and_pad(img2, size)
     
    # Grayscale
    gray1 = cv2.cvtColor(img1, cv2.COLOR_BGR2GRAY)
    gray2 = cv2.cvtColor(img2, cv2.COLOR_BGR2GRAY)

    (similar, diff) = compare_ssim(gray1, gray2, full=True)

    diff = (diff * 255).astype("uint8")
    thresh = cv2.threshold(diff, 0, 255, cv2.THRESH_BINARY_INV | cv2.THRESH_OTSU)[1]

    # Calculate contours
    contours = cv2.findContours(thresh.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    contours = imutils.grab_contours(contours)

    for contour in contours:
        if cv2.contourArea(contour) > 100:
            # Calculate bounding box around contour
            x, y, w, h = cv2.boundingRect(contour)            
            #cv2.rectangle(img1, (x, y), (x + w, y + h), (0,0,0), 2)
            cv2.rectangle(img2, (x, y), (x + w, y + h), (8,255,8), 2)
            #cv2.putText(img2, "Similarity:" + str(similar), (10, 20), cv2.FONT_HERSHEY_SIMPLEX, .7, (0, 0, 255), 2)

    # Show images with rectangles on differences

    #x = np.zeros((500, 10, 3), np.uint8)
    blank_space = np.zeros((size[0], 10, 3), np.uint8)
    result = np.hstack((img1, blank_space, img2))  
     

    output_filename = f"{timestamp}.jpg"
    output_path = f"{storepath}\\{jobcard_no}\\{output_filename}"
    # Save the result image
    cv2.imwrite(output_path, result)

    accuracy = str(similar)  # Example similarity value   
    # Save data to the database
    captured_imagename = os.path.basename(captured_image_path)
    save_to_database(jobcard_no, captured_imagename, output_filename, accuracy, created_by)

if __name__ == "__main__":   
    jobcard_no = sys.argv[1]    
    original_image = sys.argv[2]  
    created_by = sys.argv[3]  
    main(jobcard_no, original_image, created_by ) 