const formName = document.getElementsByTagName('form')[0].name
const item1Select = document.getElementById(`${formName}_item1`);
const item2Select = document.getElementById(`${formName}_item2`);
const previewImg = document.getElementsByClassName('material-service-img')[0];

document.addEventListener('DOMContentLoaded', () => {
    setImageSrc();
})

function getImageSrc() {
    const item1 = item1Select.value;
    const item2 = item2Select.value;

    return `/build/images/sign/sign/materialService/material-service-${item1}-${item2}.svg`;
}

function setImageSrc() {
    previewImg.setAttribute('src', getImageSrc());
}

item1Select.addEventListener('change', () => setImageSrc());
item2Select.addEventListener('change', () => setImageSrc());
