
import cv2
import imutils
import numpy as np
from datetime import datetime
import mysql.connector
from skimage.metrics import structural_similarity as compare_ssim
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

def main(jobcard_no, lastinsertd_id, image_name, original_image):

    print(f"jobcard_no: {jobcard_no}, imagename: {image_name}")
    storepath = "C:\\laragon\\www\\diffshade\\public\\store\\"

    original_image_path = f"{storepath}{jobcard_no}\\{original_image}"
    image_path = f"{storepath}{jobcard_no}\\{image_name}"

    img1 = cv2.imread(original_image_path)  # original
    img2 = cv2.imread(image_path)  # uploaded

    # Resize and pad images to the same dimensions
    size = (max(img1.shape[0], img2.shape[0]), max(img1.shape[1], img2.shape[1]))
    img1 = resize_and_pad(img1, size)
    img2 = resize_and_pad(img2, size)

    # Convert images to Lab color space
    lab1 = cv2.cvtColor(img1, cv2.COLOR_BGR2Lab)
    lab2 = cv2.cvtColor(img2, cv2.COLOR_BGR2Lab)

    # Split into L, a, b channels
    l1, a1, b1 = cv2.split(lab1)
    l2, a2, b2 = cv2.split(lab2)

    # Compute SSIM for each channel
    (l_similar, l_diff) = compare_ssim(l1, l2, full=True)
    (a_similar, a_diff) = compare_ssim(a1, a2, full=True)
    (b_similar, b_diff) = compare_ssim(b1, b2, full=True)

    # Combine differences
    combined_diff = (l_diff + a_diff + b_diff) / 3
    combined_diff = (combined_diff * 255).astype("uint8")
    thresh = cv2.threshold(combined_diff, 0, 255, cv2.THRESH_BINARY_INV | cv2.THRESH_OTSU)[1]

    # Calculate contours
    contours = cv2.findContours(thresh.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    contours = imutils.grab_contours(contours)

    for contour in contours:
        if cv2.contourArea(contour) > 100:
            # Calculate bounding box around contour
            x, y, w, h = cv2.boundingRect(contour)
            cv2.rectangle(img1, (x, y), (x + w, y + h), (0, 0, 255), 2)
            cv2.rectangle(img2, (x, y), (x + w, y + h), (0, 255, 0), 2)

    # Show images with rectangles on differences
    blank_space = np.zeros((size[0], 10, 3), np.uint8)
    result = np.hstack((img1, blank_space, img2))

    # Get the current date and time
    now = datetime.now()
    timestamp = now.strftime("%Y%m%d_%H%M%S")

    # Extract the file extension of the uploaded image
    file_extension = os.path.splitext(image_name)[1]
    # Create the output file name with date and time
    output_filename = f"{storepath}{jobcard_no}\\JOB_{timestamp}{file_extension}"

    # Save the result image
    cv2.imwrite(output_filename, result)

    accuracy = (l_similar + a_similar + b_similar) / 3
    accuracy_str = str(accuracy)  # Example similarity value
    imagename = f"JOB_{timestamp}{file_extension}"

    # Save data to the database
    save_to_database(jobcard_no, lastinsertd_id, imagename, accuracy_str)

if __name__ == "__main__":
    jobcard_no = sys.argv[1]
    lastinsertd_id = sys.argv[2]
    image_name = sys.argv[3]
    original_image = sys.argv[4]
    main(jobcard_no, lastinsertd_id, image_name, original_image)
