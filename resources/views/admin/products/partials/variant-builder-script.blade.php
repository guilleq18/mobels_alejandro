@section('page_scripts')
    <script>
        (() => {
            const builder = document.querySelector('[data-variant-builder]');
            const MAX_GALLERY_UPLOADS = 5;

            if (!builder) {
                return;
            }

            const variantList = builder.querySelector('[data-variant-list]');
            const variantTemplate = builder.querySelector('[data-variant-template]');
            const imageTemplate = builder.querySelector('[data-image-template]');
            const addVariantButton = builder.querySelector('[data-add-variant]');

            const updateVariantToggle = (variantItem) => {
                const toggleButton = variantItem.querySelector('[data-toggle-variant]');
                const toggleLabel = variantItem.querySelector('[data-toggle-label]');
                const toggleIcon = variantItem.querySelector('[data-toggle-icon]');
                const isCollapsed = variantItem.classList.contains('is-collapsed');

                if (!toggleButton || !toggleLabel || !toggleIcon) {
                    return;
                }

                toggleButton.setAttribute('aria-expanded', String(!isCollapsed));
                toggleLabel.textContent = isCollapsed ? 'Expandir' : 'Contraer';
                toggleIcon.textContent = isCollapsed ? '+' : '-';
            };

            const updateVariantTitle = (variantItem) => {
                const title = variantItem.querySelector('[data-variant-title]');
                const nameInput = variantItem.querySelector('[data-variant-name]');

                if (!title || !nameInput) {
                    return;
                }

                title.textContent = nameInput.value.trim() || 'Nueva melamina';
            };

            const setCollapsedState = (variantItem, shouldCollapse) => {
                variantItem.classList.toggle('is-collapsed', shouldCollapse);
                updateVariantToggle(variantItem);
            };

            const reindex = () => {
                Array.from(variantList.querySelectorAll('[data-variant-item]')).forEach((variantItem, variantIndex) => {
                    const pill = variantItem.querySelector('.pill');

                    if (pill) {
                        pill.textContent = `Melamina ${variantIndex + 1}`;
                    }

                    const nameInput = variantItem.querySelector('input[name*="[name]"]');
                    const swatchPathInput = variantItem.querySelector('input[name*="[swatch_image]"]');
                    const swatchUploadInput = variantItem.querySelector('[data-variant-swatch-upload]');
                    const galleryUploadInput = variantItem.querySelector('[data-variant-gallery-upload]');

                    if (nameInput) {
                        nameInput.name = `variants[${variantIndex}][name]`;
                    }

                    if (swatchPathInput) {
                        swatchPathInput.name = `variants[${variantIndex}][swatch_image]`;
                    }

                    if (swatchUploadInput) {
                        swatchUploadInput.name = `variant_swatch_uploads[${variantIndex}]`;
                    }

                    if (galleryUploadInput) {
                        galleryUploadInput.name = `variant_gallery_uploads[${variantIndex}][]`;
                    }

                    Array.from(variantItem.querySelectorAll('[data-image-item] input[type="text"]')).forEach((input, imageIndex) => {
                        input.name = `variants[${variantIndex}][images][${imageIndex}]`;
                    });

                    updateVariantTitle(variantItem);
                    updateVariantToggle(variantItem);
                });
            };

            const createImageRow = (variantIndex, imageIndex) => {
                const html = imageTemplate.innerHTML
                    .replace(/__INDEX__/g, String(variantIndex))
                    .replace(/__IMAGE_INDEX__/g, String(imageIndex));

                const fragment = document.createElement('div');
                fragment.innerHTML = html.trim();

                return fragment.firstElementChild;
            };

            const appendDefaultImageRow = (variantItem) => {
                const variantIndex = Array.from(variantList.children).indexOf(variantItem);
                const imageList = variantItem.querySelector('[data-image-list]');
                const imageIndex = imageList.querySelectorAll('[data-image-item]').length;
                imageList.appendChild(createImageRow(variantIndex, imageIndex));
                reindex();
            };

            addVariantButton.addEventListener('click', () => {
                const variantIndex = variantList.querySelectorAll('[data-variant-item]').length;
                const html = variantTemplate.innerHTML.replace(/__INDEX__/g, String(variantIndex));
                const wrapper = document.createElement('div');
                wrapper.innerHTML = html.trim();

                const variantItem = wrapper.firstElementChild;
                Array.from(variantList.querySelectorAll('[data-variant-item]')).forEach((item) => {
                    setCollapsedState(item, true);
                });

                variantList.prepend(variantItem);
                setCollapsedState(variantItem, false);
                appendDefaultImageRow(variantItem);
                variantItem.querySelector('[data-variant-name]')?.focus();
                reindex();
            });

            builder.addEventListener('click', (event) => {
                const toggleVariant = event.target.closest('[data-toggle-variant]');

                if (toggleVariant) {
                    const variantItem = toggleVariant.closest('[data-variant-item]');
                    setCollapsedState(variantItem, !variantItem.classList.contains('is-collapsed'));
                    return;
                }

                const removeVariant = event.target.closest('[data-remove-variant]');

                if (removeVariant) {
                    const variants = variantList.querySelectorAll('[data-variant-item]');

                    if (variants.length === 1) {
                        return;
                    }

                    removeVariant.closest('[data-variant-item]').remove();
                    reindex();
                    return;
                }

                const addImage = event.target.closest('[data-add-image]');

                if (addImage) {
                    appendDefaultImageRow(addImage.closest('[data-variant-item]'));
                    return;
                }

                const removeImage = event.target.closest('[data-remove-image]');

                if (removeImage) {
                    const imageList = removeImage.closest('[data-variant-item]').querySelector('[data-image-list]');
                    const imageRows = imageList.querySelectorAll('[data-image-item]');

                    if (imageRows.length === 1) {
                        imageRows[0].querySelector('input').value = '';
                        return;
                    }

                    removeImage.closest('[data-image-item]').remove();
                    reindex();
                }
            });

            builder.addEventListener('input', (event) => {
                const nameInput = event.target.closest('[data-variant-name]');

                if (!nameInput) {
                    return;
                }

                updateVariantTitle(nameInput.closest('[data-variant-item]'));
            });

            builder.addEventListener('change', (event) => {
                const galleryUploadInput = event.target.closest('[data-variant-gallery-upload]');

                if (!galleryUploadInput) {
                    return;
                }

                galleryUploadInput.setCustomValidity('');

                if (galleryUploadInput.files && galleryUploadInput.files.length > MAX_GALLERY_UPLOADS) {
                    galleryUploadInput.value = '';
                    galleryUploadInput.setCustomValidity(`Podés subir hasta ${MAX_GALLERY_UPLOADS} imágenes por vez en cada melamina.`);
                    galleryUploadInput.reportValidity();
                }
            });

            reindex();
        })();
    </script>
@endsection
