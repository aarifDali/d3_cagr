function updateCount() {
    var input = document.getElementById('file-upload');
    var count = input.files ? input.files.length : 0;
    var fileCountElement = document.getElementById('file-count');
    fileCountElement.textContent = count + (count === 1 ? ' file selected' : ' files selected');
}