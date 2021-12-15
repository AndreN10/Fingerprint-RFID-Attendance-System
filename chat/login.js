const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "chat/login.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if(data === "admin"){
                console.log("Hello admin");
                location.href = "show.php";
              }else if(data === "supervisor") {
                console.log("Hello supervisor");
                location.href = "supervisor/supervisor-show.php"; 
                
              } else if(data === "user") {
                console.log("Hello user");
                location.href = "user/user-show.php";

              } else {
                errorText.style.display = "block";
                errorText.textContent = data;
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}