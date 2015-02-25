/**
 *
 * @author jbgae_000
 */
window.addEventListener("DOMContentLoaded", function(){
   var canvas = document.getElementById("canvas");
   context = canvas.getContext("2d");
   video = document.getElementById("video");
   videoObj = {"video":true},
   errBack = function(error){
    console.log("Error en la captura de video", error.code);
   };
   if(navigator.getUserMedia){
       navigator.getUserMedia(videoObj, function(stream){
           video.src = stream;
           video.play();
       }, errBack);
   }
   else if(navigator.webkitGetUserMedia){
       navigator.webkitGetUserMedia(videoObj, function(stream){
           video.src = window.webkitURL.createObjectURL(stream);
           video.play();
       },errBack);
   }
   else if(navigator.mozGetUserMedia){
       navigator.mozGetUserMedia(videoObj, function(stream){
           video.src = window.URL.createObjectURL(stream);
           video.play();        
       }, errBack);
   }   
}, false);

document.getElementById("canvas").addEventListener("click", function(){
    context.drawImage(video, 0, 0,240, 240);
});