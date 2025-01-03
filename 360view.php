<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@3dweb/360javascriptviewer@1/lib/JavascriptViewer.min.js"></script>
</head>

<body>
    <div id="jsv-holder">
        <img id="jsv-image" alt="example" src="https://360-javascriptviewer.com/images/ipod/ipod.jpg">
    </div>


        
    <script>                    
        const viewer = new JavascriptViewer({
            mainHolderId: 'jsv-holder',
            mainImageId: 'jsv-image',
            totalFrames: 72,
            speed: 70,
            defaultProgressBar: true
        });
        
        // use events for example
        viewer.events().loadImage.on((progress) => {
            // use this for your own progress bar    
            console.log(`loading ${progress.percentage}%`)
        })           
         
         viewer.events().started.on((result) => {
            // use a promise or a start event to trigger things    
        })
        
         viewer.start().then(() => {
            viewer.rotateDegrees(180).then(() => {
                // continue with your amazing intro
            })
        });
    </script> 

</body>

</html>