# Img uploader 


PHP img uploader. Can be used for the development of a backend CMS (e.g. Wordpress, laravel, or custom framework or other implementation). 

The basics of this repo are the `core/inc` directory. Here you will find the `DB` connect class with config.ini credentials file.
The other class founc in this directory is the `DBQuerySelector`. This class extends `DB`, and allows for complex querying and data return to take place. 

The 2 frontend end components are `imgupload.form.php` and `displayimages.frontend.php`. The first is self explanitory and can be change ddepending on the projects needs. The second is an example of what you could do with this system, i.e. display all uploaded images in an archive page. 

The `upload.success.php` file is the success page show after a successful upload. This can be replaces with JS alert or prompt functions for a more fluid UX design. 

The fine and most important piece is the `upload.processor.php` file. Within this file all the operations of uploading happen. This is essentially the POST controller endpoint to the upload form. This file connects to the DB and copies the uploaded file into a designated media directory (currently `/images`). This controller doesn't necessarily need to connect to a DB for uploading and can process file without this functionality. However, it is recommended to work with DB when uploading files as its far easier to find specific images, and performer more complicated operations. 
