function setLightbox(arg1, arg2, arg3, arg4, arg5, arg6, arg7, arg8, arg9) {
    var imageCount = arg1,
        firstImage = arg2,
        imageType = arg3,
        imageName = arg4,
        imageFolder = arg5,
        imageRel = arg6,
        imageWidth = arg7,
        imageHeight = arg8,
        imageExtension = arg9,
        imageDir,
        imageElement;
    const defaultVar = {
        imageType: "",
        imageName: "image",
        imageFolder: "images/",
        imageRel: "lightbox",
        imageWidth: 200,
        imageHeight: 200,
        imageExtension: ".jpg",
    }
    const imageExtensions = {
        "apng",
        "avif",
        "gif",
        "jpeg",
        "jpg",
        "jfif",
        "pjpeg",
        "pjp",
        "png",
        "svg",
        "webp",
    }
    function controlLightbox() {
        if (imageType == null) {
            imageType = defaultVar.imageType;
            console.log("Error -> imageType");
        }
        if (imageName == null) {
            imageName = defaultVar.imageName;
            imageElement = imageType + imageName;
            console.log("Error -> imageName")
        } else {
            imageElement = imageType + imageName;
        }
        if (imageFolder == null) {
            imageFolder = defaultVar.imageFolder;
            console.log("Error -> imageFolder");
        } else {
            imageDir = imageFolder + imageName;
        }
        if (imageRel == null) {
            imageRel = defaultVar.imageRel;
            console.log("Error -> imageRel");
        }
        if (imageWidth == null) {
            imageWidth = defaultVar.imageWidth;
            console.log("Error -> imageWidth");
        } else {
            if (imageWidth > 0) {

            } else {
                imageWidth = defaultVar.imageWidth;
                console.log("Error -> imageWidth");
            }
        }
        if (imageHeight == null) {
            imageHeight = defaultVar.imageHeight;
            console.log("Error -> imageHeight");
        } else {
            if (imageHeight > 0) {

            } else {
                imageHeight = defaultVar.imageHeight;
                console.log("Error -> imageHeight");
            }
        }
        if (imageExtension == null) {
            imageExtension = defaultVar.imageExtension;
            console.log("Error -> imageExtension");
        } else {
            var useableExtension = false;
            imageTongue = imageExtension.split(".")[1];
            imageTongue = imageTongue.toLowerCase();
            for (var i = 0; i < imageExtensions.lenght; i++) {
                if (imageTongue == imageExtensions[i]) {
                    useableExtension = true;
                }
            }
            if (!useableExtension) {
                console.log("Error -> imageExtensionNotSupport")
            }
        }
    }
    if (firstImage != null) {
        if (imageCount >= firstImage) {
            controlLightbox();
            for (var i = firstImage; i <= imageCount; i++) {
                $(imageElement + i).attr({
                    "rel": imageRel,
                    "href": imageDir + i + imageExtension,
                });
                $(imageElement + i + " img").attr({
                    "rel": imageRel,
                    "src": imageDir + i + imageExtension,
                    "alt": imageDir + i + imageExtension,
                    "width": imageWidth,
                    "height": imageHeight,
                    "title": imageName + i,
                });
            }
            console.log("Finish -> setLightbox");
        } else {
            console.log("Error -> imageCount || firstImage");
        }
    } else {
        if (imageCount >= 1) {
            controlLightbox();
            for (var i = 1; i <= imageCount; i++) {
                $(imageElement + i).attr({
                    "rel": imageRel,
                    "href": imageDir + i + imageExtension,
                });
                $(imageElement + i + " img").attr({
                    "rel": imageRel,
                    "src": imageDir + i + imageExtension,
                    "alt": imageDir + i + imageExtension,
                    "width": imageWidth,
                    "height": imageHeight,
                    "title": imageName + i,
                });
            }
            console.log("Finish -> setLightbox");
        } else {
            console.log("Error -> imageCount");
        }
    }
}
setLightbox(8, 1, "#", "image", "images/", "lightbox[gallery]", 175, 175);