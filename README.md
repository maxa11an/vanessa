vanessa cms
----

A reformed CMS system with PHP as base.
Currently in really early stages.

Run `npm install`.

Depending on your local environment there is two ways to start vanessa.
*For Windows method 2 is recommended*
###method 1 (Unix / Linux)
`run npm serve`

This will start a local built in PHP server and watching for files

When running, the admin-panel can be found [http://localhost:8080/vanessa](http://localhost:8080/vanessa)


###method 2 (Windows / Deploy)
`run npm watch` 

Be sure that your local apache is running.

*With virtual hosts* set the directory to vanessa/public_html then locate to http://localserver/vanessa to access the admin panel.

*With just one host* locate to the absolute directory including `public_html`. Example: `http://localhost:8888/vanessa/public_html/vanessa` to access the admin panel