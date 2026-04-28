      $(document).ready(function() {

        var currentJoint,
            currentClasses;

        // Adds text markers to joints for clarity in black and white printing
        function addText(joint, textContent)
        {
          var textNode = document.createElementNS("http://www.w3.org/2000/svg", "text");
          var boundingBox = joint[0].getBBox();
          // console.log(boundingBox);
          textNode.setAttribute("transform", "translate(" + (boundingBox.x + boundingBox.width/2) + " " + (boundingBox.y + boundingBox.height/2) + ")");
          textNode.setAttribute("text-anchor", "middle");
          textNode.setAttribute("y", ".3em");
          textNode.textContent = textContent;
          textNode.setAttribute("fill", "black");
          // console.log(boundingBox);
          if(boundingBox.width < 80){
            textNode.setAttribute("font-size", "40");
          }else{
            textNode.setAttribute("font-size", "60");
          }

          var refEl  = joint.nextSibling || null;
          
          // parent.insertBefore(newRowHolderNode.childNodes[0], refEl);
          joint[0].parentNode.insertBefore(textNode, refEl);
        }

        // Colors in the joints on the mannequin
        function markJoints(){
          if (tenderJoints != null && tenderJoints != ''){
            tenderJoints = tenderJoints.split(',');

            jQuery.each(tenderJoints, function(index, jointID){
              currentJoint = $('#'+jointID);
              addText(currentJoint, 'T');
              currentJoint.css({ fill: "#FBCD33" });
            });
          }
          if (swollenJoints != null && swollenJoints != ''){
            swollenJoints = swollenJoints.split(',');

            jQuery.each(swollenJoints, function(index, jointID){
              currentJoint = $('#'+jointID);
              addText(currentJoint, 'S');
              currentJoint.css({ fill: "#F28330" });
            });
          }
          if (tenderswollenJoints != null && tenderswollenJoints != ''){
            tenderswollenJoints = tenderswollenJoints.split(',');

            jQuery.each(tenderswollenJoints, function(index, jointID){
              currentJoint = $('#'+jointID);
              addText(currentJoint, 'TS');
              currentJoint.css({ fill: "#ED484D" });
            });
          }
        }

        

        function svgToCanvas(){
          // #1 - Convert SVG into canvas
          svg = $('<div>').append($('#homunculus').clone()).html();
          // convert svg to canvas using canvg
          canvg(document.getElementById('canvas'), svg);
          canvg('canvas', svg, { ignoreMouse: true, ignoreAnimation: true });
          // hide svg
          $('#homunculus').hide();
        }

        function prependAndRepaint(message, classToAdd){
          if(classToAdd){ 
            $('body').prepend('<div id="loading-info" class="' + classToAdd + '">'+message+'</div>');
          }
          else{
            $('body').prepend('<div id="loading-info">'+message+'</div>');
          }

          $('#loading-info').hide();
          $('#loading-info').get(0).offsetHeight;
          $('#loading-info').show();
        }

        function htmlToCanvas(){

          // $('#page').addClass('.x2');

          html2canvas($('#page'), {
              onrendered: function(canvas) {
                  // canvas is the final rendered <canvas> element
                $('#page').empty();
                $('#page').append(canvas);


                console.log('rendered html 2 canvas');
                

                if(exportType == 'print'){
                  // console.log('print');
                  window.print();
                }else{
                  // # 3 - Convert canvas into an image
                  var image = new Image();
                  image.src = canvas.toDataURL("image/png");
                  $('#page').empty();
                  $('body').prepend('<div id="page-container"></div>');
                  // $('#page-container').append(image);


                  console.log('rendered canvas to image');
                }




                

                if(exportType == 'copy' || exportType == 'save'){

                  console.log('export type is copy or save');

                  prependAndRepaint('<img src="images/360-red.GIF" alt="Spinning wheel"> Loading image, please wait...');

                  console.log('prependAndRepaint the loading gif');

                  $.ajax({
                    type: "POST",
                    url: "save-image.php",
                    data: { 
                       imgBase64: image.src
                    },
                    dataType: 'json',
                    success: function(data) {
                      // response = JSON.parse(data);

                      
                    }
                  }).done(function(data) {

                    console.log(data);

                    if(data['status'] == 'success'){

                      if(exportType == 'copy'){
                        $('#loading-info').html('<strong>Copy Image:</strong> Right-click the image below and choose "Copy" or "Copy Image"');
                      }
                      else{
                        $('#loading-info').html('<strong>Save Image:</strong> Right-click the image below and choose "Save Image As..." or "Save picture as..."');
                      }
                      $('#page-container').append('<img src="' + data['file'] + '">');
                    }
                    else{

                      if(exportType == 'save'){
                        prependAndRepaint('<span class="icon-x"></span> <strong>Note:</strong> There was a problem storing the image but you may still be able to save the image below.', 'failure');
                        $('#loading-info').html('<strong>Save Image:</strong> Right-click the image below and choose "Save Image As..." or "Save picture as..."');
                        $('#page-container').append(image);
                      }
                      else{
                        $('#loading-info').html('<strong>Copy Image:</strong> Right-click the image below and choose "Copy" or "Copy Image"');
                        prependAndRepaint('<span class="icon-x"></span> <strong>Note:</strong> There was a problem storing the image but you may still be able to copy and paste the image below.', 'failure');
                        $('#page-container').append(image);
                      }

                    }

                  });


                }

                console.log('export type is not copy or save');
  
                if(exportType == 'email'){

                  prependAndRepaint('<img src="images/360-red.GIF" alt="Spinning wheel"> Sending email message, please wait...');

                  $.ajax({
                    type: "POST",
                    url: "email-image.php",
                    data: { 
                       imgBase64: image.src,
                       emailTo: emailAddress
                    },
                    dataType: 'json',
                    success: function(data) {
                      // response = JSON.parse(data);
                      console.log(data);
                      if(data['status'] == 'success' || data['status'] == 'partial'){
                        $('#loading-info').html('<span class="icon-check"></span> Message sent! Your report has been emailed to ' + emailAddress).addClass('success');
                      }
                      else if(data['status'] == 'missing_email'){
                        $('#loading-info').html('<span class="icon-x"></span> Couldn\'t send the file because the email address to send to was missing or invalid. Please try again with a valid email address.').addClass('failure');
                      }
                      else{
                        $('#loading-info').html('<span class="icon-x"></span> Sorry! There was a problem and the message could not be sent. Please try again.').addClass('failure');
                      }
                      
                    }
                  }).done(function(data) {
                    console.log('sent'); 
                    // If you want the file to be visible in the browser 
                    // - please modify the callback in javascript. All you
                    // need is to return the url to the file, you just saved 
                    // and than put the image in your browser.
                  });
                }
              }
          });
        }


        markJoints();

        svgToCanvas();

        htmlToCanvas();


      });
