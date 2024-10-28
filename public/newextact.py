import fitz  # PyMuPDF
from PIL import Image
import sys
import os
import io


storepath = "C:\\laragon\\www\\diffshade\\public\\store"
folder = "58"

pdf_path = os.path.join(storepath, folder, "original.pdf")
output_image_path = os.path.join(storepath, folder, "original.jpg")

# Open the PDF file
pdf_document = fitz.open(pdf_path)

# Select the page number (0 for the first page, 1 for the second, etc.)
page_num = 0
page = pdf_document[page_num]

# Render the page as a PNG image
pix = page.get_pixmap(dpi=300)  # You can adjust DPI for higher resolution if needed
pix.save(output_image_path)

# Close the PDF document
pdf_document.close()
     
