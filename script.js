
const userBtn = document.querySelector('#user-btn');
userBtn.addEventListener('click',function(){
    const userBox = document.querySelector('.profile-detail');
    userBox.classList.toggle('active');
})

