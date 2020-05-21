class UploadManager {

    constructor(dragFieldName) {
        this.dragField = dragFieldName;
        this.dragFieldActiveName = 'uploaderactive';
        this.dragFieldIdleName = 'uploaderidle';
        this.dragEnterEventName = 'dragenter';
        this.dragLeaveEventName = 'dragleave';
        this.dragOverEventName = 'dragover';
        this.dropEventName = 'drop';
        this.severityInfo = 'info';
        this.severityAlarm = 'alarm';
        this.chartPath = '../charts/';
        this.uploadScript = '../server/file_upload.php';
        this.removeChartsScript = '../server/remove_charts.php';
        this.filename = '';
    }

    checkSupport() {
        return window.FileReader && window.Blob && window.FormData && XMLHttpRequest;
    }

    dragFieldActive() {
        let uploader = document.getElementById(this.dragField);
        uploader.className = this.dragFieldActiveName;
    }

    dragFieldIdle() {
        let uploader = document.getElementById(this.dragField);
        uploader.className = this.dragFieldIdleName;
    }

    updateServerInfo(info, severity = 'info') {
        let infotext = document.getElementById('infotext');
        if (severity == this.severityInfo) {
            infotext.className = 'serverinfo';
        } else {
            infotext.className = 'alarm';
        }
        infotext.innerHTML = info;
    }

    hideInfo() {
        let infotext = document.getElementById('infotext');
        infotext.className = '';
        infotext.innerHTML = '';
    }

    disableWindowDragAndDrop() {
        function disable(e) {
            e.preventDefault();
        }

        window.addEventListener(this.dropEventName, function (e) {
            disable(e);
        }, false);

        window.addEventListener(this.dragOverEventName, function (e) {
            disable(e);
        }, false);
    }

    getFilenameFromContentDisposition(header) {
        const quote = '"';
        let firstIndex = header.indexOf(quote);
        let lastIndex = header.lastIndexOf(quote);
        return header.substr(firstIndex + 1, lastIndex - firstIndex - 1);
    }

    prepareFileReader(context) {
        let fileReader = new FileReader();
        fileReader.onload = e => {
            const anchor = document.createElement('a');
            anchor.style.display = 'none';
            anchor.href = e.target.result;
            anchor.download = context.filename;
            context.hideInfo();
            anchor.click();
        };
        return fileReader;
    }

    getChartNames(filename) {
        let suffixes = ['after', 'before'];
        let output = [];

        let pos = filename.indexOf('.');
        let radical = filename.slice(0, pos);

        let suffix = suffixes[0];
        for (suffix of suffixes) {
            let tmp = radical + '_' + suffix + '.png';
            output.push(tmp);
        }

        return output;
    }

    clearChartArea() {
        let chartArea = document.getElementById('charts');
        while (chartArea.firstChild) {
            chartArea.removeChild(chartArea.firstChild);
        }
    }

    getChartNameFromURI(uri) {
        let index = uri.lastIndexOf('/');
        let chartName = uri.slice(index + 1, uri.length);
        return chartName;
    }

    getFilenameFromContentDisposition(content) {
        let openingQuote = content.indexOf('"') + 1;
        let closingQuote = content.lastIndexOf('"');
        return content.substring(openingQuote, closingQuote);
    }

    prepareImageContainer(event) {
        let container = document.getElementById('charts');
        let img = document.createElement('img');
        img.setAttribute('src', event.target.src);
        img.setAttribute('draggable', 'false');
        img.className = 'chartstyle';
        container.appendChild(img);
    }

    manageCharts(context, chartNames) {
        for (name of chartNames) {
            let image = new Image();
            image.onload = (e) => {
                context.prepareImageContainer(e);
                let chartToRemove = context.getChartNameFromURI(e.target.src);
                let chartData = new FormData();
                chartData.append('charts_to_remove', chartToRemove);
                fetch(context.removeChartsScript, {
                    method: 'POST',
                    body: chartData
                })
                .catch(err => {
                    context.updateServerInfo('Error occured: ' + err + '. Check the file format. If it is supported report the problem using Contact tab', 'alarm');
                });
            }
            image.src = context.chartPath + name;
        }
    }

    processFiles(context, formData) {
        context.clearChartArea();
        fetch(context.uploadScript, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            let content = response.headers.get('Content-disposition');
            context.filename = context.getFilenameFromContentDisposition(content);
            return response.blob();
        })
        .then(blob => {
            context.prepareFileReader(context).readAsDataURL(blob);
        })
        .then(() => {
            let chartNames = context.getChartNames(context.filename);
            context.manageCharts(context, chartNames);
        })
        .catch(err => {
            console.log(`Error: ${err}`);
            context.updateServerInfo('Error occured: ' + err + '. Check the file format. If it is supported report the problem using Contact tab', 'alarm');
        });
    }

    processFileFromInput(e, context) {
        context.updateServerInfo('Please wait, processing in progress...');
        let fileInput = document.getElementById('upload');
        let formData = new FormData();
        if(fileInput.files.length > 0) {
            formData.append('upfile', fileInput.files[0]);
        }
        context.processFiles(context, formData);
    }

    initButtonEvents() {
        if (this.checkSupport() == false) {
            alert("Your browser is probably lacking the support some features needed for this website to work correctly. Please update or use another browser.");
            return;
        }

        let submit = document.getElementById('submit');
        let context = this;
        submit.addEventListener('click', (e) => {
            context.processFileFromInput(e, context);
        });
    }

    initDragField() {

        if (this.checkSupport() == false) {
            return;
        }

        let uploader = document.getElementById(this.dragField);
        let context = this;

        uploader.addEventListener(this.dragEnterEventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            context.dragFieldActive();
        });

        uploader.addEventListener(this.dragOverEventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        })

        uploader.addEventListener(this.dragLeaveEventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            context.dragFieldIdle();
        });

        uploader.addEventListener(this.dropEventName, (e) => {
            e.preventDefault();
            e.stopPropagation();

            context.updateServerInfo('Please wait, processing in progress...');
            context.dragFieldIdle();
            let data = new FormData();
            if(e.dataTransfer.files.length > 0) {
                data.append('upfile', e.dataTransfer.files[0]);
            } else {
                throw Error("Problem occured with receiving the files");
            }
            context.processFiles(context, data);
        });
    }
}


window.addEventListener('load', () => {
    uploadManager = new UploadManager('uploader');
    uploadManager.disableWindowDragAndDrop();
    uploadManager.initDragField();
    uploadManager.initButtonEvents();
});
