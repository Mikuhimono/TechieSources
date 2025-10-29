# PSEUDOCODE

# ❗ This pseudocode is to guide others to understand how this website works. 

```pgsql
START WEBSITE

LOAD index.php
    CHECK user session
    IF user is already logged in
        REDIRECT to html/home.html
    ELSE
        REDIRECT to html/login.html
    ENDIF

LOAD html/login.html (if not logged in)
    DISPLAY website title
    SHOW login form (username and password)

WHEN user submits login form
    SEND POST request to php/login.php with username and password
    IF php/login.php validates credentials
        START session
        REDIRECT to html/home.html
    ELSE
        SHOW error message: "Invalid username or password"
    ENDIF

LOAD html/home.html (after successful login)
    DISPLAY website title
    SHOW sidebar menu (Content, Purpose, Creator)

WHEN user clicks ☰ button
    TOGGLE sidebar visibility (open/close)

IF user clicks "ICT Research" (content.html)
    CALL php/fetch_pdfs.php
        READ pdf_data.json
        RETURN list of research PDFs
    DISPLAY list of PDFs on content page
    FOR each PDF
        SHOW title + year + buttons (View, Download)

    IF user clicks "View" button
        OPEN view.php with PDF file parameter
        DETECT device type (mobile/desktop)
        IF device = desktop
            DISPLAY PDF in embedded viewer
        ELSE
            REDIRECT or PROMPT download on mobile
        ENDIF
    ENDIF

    IF user clicks "Download" button
        OPEN download.php with PDF file parameter
        FORCE download of PDF to user device
    ENDIF
ENDIF

IF user clicks "Purpose" (purpose.html)
    DISPLAY text explaining website purpose (why the website exists)
    SHOW short mission statement
ENDIF

IF user clicks "Researchers" (creator.html)
    DISPLAY information about the developers/creators/researchers who built the website
    SHOW their names, roles, photos
ENDIF

IF user clicks "Logout"
    CALL php/logout.php
    DESTROY session
    REDIRECT to html/login.html
ENDIF

SEARCH FUNCTION (available only after login)
    WHEN user enters keyword (in home.html or content.html)
        CALL php/fetch_pdfs.php?search=<keyword>
        FILTER results by title or year
        DISPLAY matching PDFs dynamically

END WEBSITE

```



