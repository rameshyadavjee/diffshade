import fitz  # PyMuPDF
from PIL import Image
import sys
import os
import io

def main(jobcard):   
    storepath = "C:\\laragon\\www\\diffshade\\public\\store"
    folder = jobcard

    pdf_path = os.path.join(storepath, folder, "original.pdf")
    output_image_path = os.path.join(storepath, folder, "original.jpg")
        
    # Open the PDF file
    pdf_document = fitz.open(pdf_path)
    # Select the first page (0 for the first page)
    page = pdf_document[0]

    # Render the page as an image
    pix = page.get_pixmap(dpi=150)  # You can adjust DPI for higher resolution if needed

    # Convert to PIL Image and save as JPEG
    img_data = pix.tobytes("ppm")  # Convert Pixmap to PPM format for Pillow compatibility
    img = Image.open(io.BytesIO(img_data)).convert("RGB")  # Convert to RGB for JPEG
    img.save(output_image_path, "JPEG")  # Save as JPEG

    # Close the PDF document
    pdf_document.close()

if __name__ == "__main__":   
    jobcard = sys.argv[1]
    #jobcard = 'aaa'
    main(jobcard)
