class UploadManager {

    constructor(dragFieldName) {
        this.dragField = dragFieldName;
        this.dragFieldActiveName = 'uploaderactive';
        this.dragFieldIdleName = 'uploaderidle';
        this.dragEnterEventName = 'dragenter';
        this.dragLeaveEventName = 'dragleave';
        this.dragOverEventName = 'dragover';
        this.dropEventName = 'drop';
    }

    checkSupport() {
        return window.FileReader && window.Blob && window.FormData && XMLHttpRequest;
    }

    dragFieldActive() {
        var uploader = document.getElementById(this.dragField);
        uploader.className = this.dragFieldActiveName;
    }
    
    dragFieldIdle() {
        var uploader = document.getElementById(this.dragField);
        uploader.className = this.dragFieldIdleName;
    }

    updateServerInfo() {
        var infotext = document.getElementById('infotext');
        infotext.className = 'serverinfo';
        infotext.innerHTML = 'Please wait, processing in progress...';
    }

    hideInfo() {
        var infotext = document.getElementById('infotext');
        infotext.className = '';
        infotext.innerHTML = '';
    }

    disableWindowDragAndDrop() {

        function disable(e) {
            e.preventDefault();
        }

        window.addEventListener(this.dropEventName, function(e) {
            disable(e);
        }, false);

        window.addEventListener(this.dragOverEventName, function(e) {
            disable(e);
        }, false);
    }

    getFilenameFromContentDisposition(header) {
        const quote = '"';
        var firstIndex = header.indexOf(quote);
        var lastIndex = header.lastIndexOf(quote);
        return header.substr(firstIndex + 1, lastIndex - firstIndex - 1);
    }

    prepareFileReader(blob, context) {
        var fileReader = new FileReader();
        fileReader.onload = e => {
            const anchor = document.createElement('a');
            anchor.style.display = 'none';
            anchor.href = e.target.result;
            anchor.download = blob.name;
            context.hideInfo();
            anchor.click();
        };

        return fileReader;
    }

    prepareFileUploadRequest(e, context) {
        var xhr = new XMLHttpRequest();
        xhr.responseType = "blob"; // important - w/o this it will deform audio file
        xhr.open('POST', '../server/file_upload.php', true);
        xhr.onload = function (e) {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const filetype = xhr.getResponseHeader('Content-type');
                    const contentDisposition = xhr.getResponseHeader('Content-disposition');
                    var blob = new Blob([xhr.response], {type: filetype});
                    blob.name = context.getFilenameFromContentDisposition(contentDisposition);
                    var reader = context.prepareFileReader(blob, context);
                    reader.readAsDataURL(blob);
                }
            } else {
                alert('Upload error!');
            }
        };

        xhr.onerror = function (e) {
            alert('Upload error!');
        };

        return xhr;
    }

    getFileFromInput(e, context) {
        context.updateServerInfo();
        var upload = document.getElementById('upload');
        if('files' in upload) {
            for(var i = 0; i < upload.files.length; i++) {
                var data = new FormData();
                data.append('upfile', upload.files[i]);
                var xhr = context.prepareFileUploadRequest(e, context);
                xhr.send(data);
            }
        }
    }

    initButtonEvents() {

        if(this.checkSupport() == false) {
            alert("Your browser is probably lacking the support some features needed for this website to work correctly. Please update or use another browser.");
            return;
        }

        var submit = document.getElementById('submit');
        var context = this;
        submit.addEventListener('click', function(e) {
            context.getFileFromInput(e, context);
        });
    }

    initDragField() {

        if(this.checkSupport() == false) {
            return;
        }

        var uploader = document.getElementById(this.dragField);
        var context = this;

        uploader.addEventListener(this.dragEnterEventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
            context.dragFieldActive();
        });

        uploader.addEventListener(this.dragOverEventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
        })
        
        uploader.addEventListener(this.dragLeaveEventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
            context.dragFieldIdle();
        });
        
        uploader.addEventListener(this.dropEventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            context.updateServerInfo();
            context.dragFieldIdle();
            for (var i = 0; i < e.dataTransfer.files.length; i++) {
                var data = new FormData();
                data.append('upfile', e.dataTransfer.files[i]);
                var xhr = context.prepareFileUploadRequest(e, context);
                xhr.send(data);
                break;
            }
        });
    }
}


window.addEventListener('load', function () {
    uploadManager = new UploadManager('uploader');
    uploadManager.disableWindowDragAndDrop();
    uploadManager.initDragField();
    uploadManager.initButtonEvents();
  });