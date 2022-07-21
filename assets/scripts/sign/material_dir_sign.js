const formName = document.getElementsByTagName('form')[0].name
const titleSelect = document.getElementById(`${formName}_title`);
const dirSelect = document.getElementById(`${formName}_direction`);
const previewImg = document.getElementsByClassName('material-dir-img')[0];

document.addEventListener('DOMContentLoaded', () => {
    setImageSrc();
})

function getImageSrc() {
    const title = titleSelect.value;
    const dir = dirSelect.value;

    return `/build/images/sign/sign/materialDir/material-dir-bg-${title}-${dir}.svg`;
}

function setImageSrc() {
    previewImg.setAttribute('src', getImageSrc());
}

titleSelect.addEventListener('change', () => setImageSrc());
dirSelect.addEventListener('change', () => setImageSrc());
