# PSEUDOCODE

### ❗ This pseudocode is to guide others to understand how this website works. 
----
**THIS IS OUTDATED, We will fix this if the website is complete.**
----  
```pgsql
START WEBSITE

LOAD home.html
    DISPLAY website title and logo
    SHOW sidebar menu (Content, Purpose, Creator)

WHEN user clicks ☰ button
    TOGGLE sidebar visibility (open/close)

IF user clicks "ICT Research" (content.html)
    CALL fetch_pdfs.php
        READ pdf_data.json
        RETURN list of research
    DISPLAY list of PDFs on content page
    FOR each PDF
        SHOW title + year + buttons (View, Download)

IF user clicks "View" button
    OPEN view.php with PDF file parameter
    DISPLAY PDF in browser

IF user clicks "Download" button
    OPEN download.php with PDF file parameter
    FORCE download of PDF to user device
  ENDIF
 ENDIF
ENDIF

IF user clicks "Purpose" (purpose.html)
    DISPLAY text explaining hub purpose
ENDIF

IF user clicks "Researchers" (creator.html)
    DISPLAY list of researchers/creator
ENDIF

IF user uploads a PDF
    SEND file to upload.php
    SAVE file in server folder
    UPDATE pdf_data.json with new file info
 ENDIF
END WEBSITE


```
