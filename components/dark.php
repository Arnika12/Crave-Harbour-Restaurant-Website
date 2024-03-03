
<div class="day-night">
    <i class="bx"></i>
</div>
<script>
    const datNight = document.querySelector('.day-night');

    datNight.addEventListener('click', () => {
        document.body.classList.contains("dark");
        if(document.body.classList.contains("dark")){
            localStorage.setItem("theme", "dark");
        }
        else{
            localStorage.setItem("theme", "light");
        }
        updateIcon();
    })

    function themeMode(){
        if(localStorage.setItem("theme") !== null){
            if(localStorage.setItem("theme") === "light"){
                document.body.classList.remove("dark");
            }
            else{
                document.body.classList.add("dark");
            }
        }
        updateIcon();
    }
    themeMode();

    function updateIcon(){
        if(document.body.classList.contains("dark")){
            datNight.querySelector("i").classList.add("bxs-sun");
            datNight.querySelector("i").classList.remove("bxs-moon");
        }
        else{
            datNight.querySelector("i").classList.remove("bxs-sun");
            datNight.querySelector("i").classList.add("bxs-moon");
        }
    }
</script>