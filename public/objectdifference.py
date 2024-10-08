import cv2
import numpy as np
import matplotlib.pyplot as plt
from datetime import datetime
import mysql.connector
import sys
import os

# MySQL connection details
db_config = {
    'user': 'root',
    'password': '',
    'host': 'localhost',
    'database': 'diffshade'
}

# Function to save data to the MySQL database
def save_to_database(jobcard_no, lastinsertd_id, imagename, accuracy):
    try:
        # Connect to the database
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        # SQL query to update data
        query = "UPDATE diffshadedetail SET output_image = %s, accuracy = %s WHERE id = %s and jobcard_no = %s"
        values = (imagename,  accuracy, lastinsertd_id, jobcard_no,)

        # Execute the query and commit the transaction
        cursor.execute(query, values)
        conn.commit()

        print("Data saved successfully")

    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        cursor.close()
        conn.close()
#$jobcard_no $lastinsertedId $imagename $original_image
def convert_png_to_jpg(image_path):
    img = cv2.imread(image_path, cv2.IMREAD_UNCHANGED)
    if img is None:
        raise ValueError(f"Image at {image_path} could not be read.")
    if img.shape[2] == 4:  # Has alpha channel
        alpha_channel = img[:, :, 3]
        rgb_channels = img[:, :, :3]
        white_background = np.ones_like(rgb_channels, dtype=np.uint8) * 255
        alpha_factor = alpha_channel[:, :, np.newaxis] / 255.0
        img = rgb_channels * alpha_factor + white_background * (1 - alpha_factor)
        img = img.astype(np.uint8)
    return img
 
#save_to_database(jobcard_no, , , accuracy)
def main(jobcard_no, lastinsertd_id, image_name, original_image):

    storepath = "C:\\laragon\\www\\diffshade\\public\\store\\"
    original_image_path = f"{storepath}{jobcard_no}\\{original_image}"
    image_path = f"{storepath}{jobcard_no}\\{image_name}"    

    img1 = cv2.imread(original_image_path)  # original
    img2 = cv2.imread(image_path)  # uploaded
 
    if img1.shape[:2] != img2.shape[:2]:    
        img1 = cv2.resize(img1, (img2.shape[1], img2.shape[0]))
    
    # Compute absolute difference between images
    difference = cv2.absdiff(img1, img2)
    difference_gray = cv2.cvtColor(difference, cv2.COLOR_BGR2GRAY)

    # Making difference more brightness using masking.        
    _, mask = cv2.threshold(difference_gray,10,255, cv2.THRESH_BINARY)
    cv2.bitwise_not(mask)    
    heatmap_difference = np.zeros_like(img1)
    heatmap_difference[mask != 0] = [255, 255, 255]  # White color (BGR format)    
    difference_result = cv2.cvtColor(heatmap_difference, cv2.COLOR_BGR2RGB)
    
    # Get the current date and time
    now = datetime.now()
    timestamp = now.strftime("%Y%m%d_%H%M%S")

    # Extract the file extension of the uploaded image
    file_extension = os.path.splitext(image_name)[1]
    # Create the output file name with date and time    
    output_filename = f"{storepath}{jobcard_no}\\JOB_{timestamp}{file_extension}"

    # Save the result image
    cv2.imwrite(output_filename, difference_result)
    accuracy = ""
    imagename = f"JOB_{timestamp}{file_extension}"

    # Save data to the database
    save_to_database(jobcard_no, lastinsertd_id, imagename, accuracy)

if __name__ == "__main__":   
    jobcard_no = sys.argv[1]
    lastinsertd_id = sys.argv[2]
    image_name = sys.argv[3]      
    original_image = sys.argv[4]  
    main(jobcard_no, lastinsertd_id, image_name, original_image )
