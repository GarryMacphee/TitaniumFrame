var app = app || {};

//self invoking function
(function (o)
   {
      "use strict";

      //private methods
      var ajax, getFormData, setProgress;

      //our AJAX call object with the form data object
      ajax = function (data)
         {
            var xmlhttp = new XMLHttpRequest();
            var uploaded;

            xmlhttp.addEventListener('readystatechange', function ()
               {
                  //operation complete
                  if (this.readyState === 4)
                     {
                        //status is success
                        if (this.status === 200)
                           {
                              //parse our response
                              //uploaded = JSON.parse(this.response);

                               uploaded = this.response;

                                console.log(uploaded);
                              
                              //if finished pass the parsed response to our callback
                              if (typeof o.options.finished === 'function')
                                 {
                                    o.options.finished(uploaded);
                                 }
                           }
                        else
                           {  
                              //if there was an error
                              if (typeof o.options.error === 'function')
                                 {
                                    o.options.error;//do more error handling
                                 }
                           }
                     }
               });
               
               xmlhttp.upload.addEventListener('progress', function(e) {
                    var percent;
                  
                    if(e.lengthComputable === true)
                       {
                          percent = Math.round((event.loaded / event.total) * 100);
                          setProgress(percent);
                       }
               });
               
              //open a connection to send our files
              xmlhttp.open('post', o.options.processor);
              //xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              xmlhttp.send(data);
         };
         
      //add form data to object for easy processing via JSON
      getFormData = function (source)
         {
            var data = new FormData();//FormData used to send results to server

            for (var i = 0; i < source.length; i++)
               {
                  data.append('files[]', source[i]);
               }
               
               var formKey = document.getElementById('form_key');
               data.append('form_key', formKey.value);

            return data;
         };

      setProgress = function (value)
         {
            //set the progress bar width to increase
            if(o.options.progressBar !== undefined)
               {
                  o.options.progressBar.style.width = value ? value + '%' : 0;
               }
            
            //set the progress text % value
            if(o.options.progressText !== undefined)
               {
                  o.options.progressText.textContent = value ? value + '%' : '';
               }
         };

      //options passed from the app object after file added
      o.uploader = function (options)
         {
            o.options = options;
            if (o.options.files !== undefined)
               {
                  //put data into object send via JSON
                  ajax(getFormData(o.options.files));
               }
         };
   }(app));
