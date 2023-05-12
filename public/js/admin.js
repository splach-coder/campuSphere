$(document).ready(function () {

    //set the clock
    digitalClock();

    //open and close the sidebar
    $(".toggle").click(function () {
        $(".sidebar").toggleClass('close');
    });
});

function digitalClock() {
    const clock = document.getElementById('clock');
    const formatTime = (time) => time < 10 ? `0${time}` : time;

    setInterval(() => {
        const now = new Date();
        let hours = now.getHours();
        let amPm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;
        const minutes = formatTime(now.getMinutes());
        const seconds = formatTime(now.getSeconds());
        clock.innerText = `${hours}:${minutes}:${seconds} ${amPm}`;
    }, 1000);
}