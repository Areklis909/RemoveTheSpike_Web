
window.addEventListener("load", function () {
    var uploader = document.getElementById('uploader');

    uploader.addEventListener("dragover", function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    uploader.addEventListener("drop", function (e) {
        e.preventDefault();
        e.stopPropagation();

        for (var i = 0; i < e.dataTransfer.files.length; i++) {
            var xhr = new XMLHttpRequest();
            var data = new FormData();
            data.append('upfile', e.dataTransfer.files[i]);
            xhr.responseType = "blob"; // important - w/o this it will deform audio file
            xhr.open('POST', '../server/file_upload.php', true);
            xhr.onload = function (e) {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const filetype = xhr.getResponseHeader('Content-type');
                        console.log("Result: " + xhr.response);
                        var blob = new Blob([xhr.response], {type: filetype});
                        blob.name = 'muza.wav';
                        const reader = new FileReader();
                        reader.onload = e => {
                            const anchor = document.createElement('a');
                            anchor.style.display = 'none';
                            anchor.href = e.target.result;
                            anchor.download = blob.name;
                            anchor.click();
                        };
                        reader.readAsDataURL(blob);
                    }
                } else {
                    alert("Upload error!");
                }
            };

            xhr.onerror = function (e) {
                alert("Upload error!");
            };

            xhr.send(data);
        }
    });

  });