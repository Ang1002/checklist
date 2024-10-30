const fileUpload = document.getElementById('file-upload');
        const previewContainer = document.getElementById('image-preview');
        const fileCountDisplay = document.getElementById('file-count');
        let fileList = [];

        function updatePreviews() {
            previewContainer.innerHTML = '';
            fileList.forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    
                    // Create remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = 'X';
                    removeBtn.className = 'remove-btn';
                    removeBtn.onclick = function() {
                    fileList = fileList.filter(f => f !== file);
                        updatePreviews();
                    };

                    // Create container for image and button
                    const imgWrapper = document.createElement('div');
                    imgWrapper.className = 'img-wrapper';
                    imgWrapper.appendChild(img);
                    imgWrapper.appendChild(removeBtn);

                    previewContainer.appendChild(imgWrapper);
                };
                reader.readAsDataURL(file);
            });
            updateFileCount();
        }

        function updateFileCount() {
            const count = fileList.length;
            fileCountDisplay.textContent = `Archivos: ${count}`;
        }

        fileUpload.addEventListener('change', function(event) {
            const newFiles = Array.from(event.target.files);
            fileList = [...fileList, ...newFiles];
            updatePreviews();
            // Clear the input value to allow re-uploading the same file
            fileUpload.value = '';
        });

