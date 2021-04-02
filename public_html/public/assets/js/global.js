/* global app */
//event handler for the dropzone
(function ()
    {
        "use strict";

        var dropZone        = document.getElementById('drop-zone');
        var barFill         = document.getElementById('bar-fill');
        var barFillText     = document.getElementById('bar-fill-text');
        
        var startUpload = function(files)
            {
                app.uploader({          //app defined in uploads.js
                    files: files,
                    progressBar: barFill,
                    progressText: barFillText,
                    processor: 'tmpuploads/fileupload',

                    finished: function(data)
                        {
                            console.log(data);
                            
                            var inc;                // increment counter
                            var uploadedElement;    // outer div
                            var uploadedAnchor;     // link to view file
                            var uplodedStatus;      // status of file
                            var currFile;
                            var imgElement;          //img tag for thumbnail
                            
                            var uploadsFinished = document.getElementById('uploads-finished');
                            
                            for (inc = 0; inc < data.length; inc = inc + 1)
                                {
                                    currFile = data[inc];
                                    
                                    //outer div
                                    uploadedElement = document.createElement('div');
                                    uploadedElement.className = 'upload-console-upload';
                                    
                                    //inside div - a tag link
                                    uploadedAnchor = document.createElement('a');
                                    uploadedAnchor.textContent = currFile.name;
                                    
                                    //img tag inside a tag
                                    imgElement = document.createElement('img');
                                    
                                    //provide a link to view the file if upload is successful
                                    if(currFile.uploaded)
                                        {
                                            uploadedAnchor.href = currFile.file;
                                            imgElement.src = currFile.file;
                                            
                                            imgElement.className = 'img-fluid';
                                        }
                                        
                                    uplodedStatus = document.createElement('span');
                                    uplodedStatus.textContent = currFile.uploaded ? 'Uploaded' : 'Failed';
                                    
                                    uploadedElement.appendChild(uploadedAnchor);
                                    
                                    uploadedAnchor.appendChild(imgElement);
                                    
                                    uploadedElement.appendChild(uplodedStatus);
                                    
                                    uploadsFinished.appendChild(uploadedElement);
                                }
                            
                            uploadsFinished.className = '';
                        },

                    error: function ()
                        {
                            alert('There was an error uploading file');
                        }
                });
            };

        //standard form upload
        document.getElementById('standard-upload').addEventListener('click', function (e) //submit button 
            {
                var standardUploadfiles = document.getElementById('standard-upload-files').files; //browse button
                e.preventDefault();

                startUpload(standardUploadfiles);
            });

        //drag and drop
        dropZone.ondrop = function (e)
            {
                e.preventDefault();
                this.className = 'upload-console-drop';

                startUpload(e.dataTransfer.files);
            };

        dropZone.ondragover = function ()
            {
                this.className = 'upload-console-drop drop';
                return false;
            };

        dropZone.ondragleave = function ()
            {
                this.className = 'upload-console-drop';
                return false;
            };
    }());