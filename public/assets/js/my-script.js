const links = document.querySelectorAll(".show-form");
const forms = document.querySelectorAll(".form");

const showPosts = document.getElementById("showPosts");
const postList = document.getElementById("postList");


// Show normal forms
links.forEach(link => {

    link.addEventListener("click", function(event) {

        event.preventDefault();

        // hide post list
        if (postList) {
            postList.style.display = "none";
        }

        // hide all forms
        forms.forEach(form => {
            form.style.display = "none";
        });

        const formId = this.dataset.form;

        document.getElementById(formId).style.display = "block";

    });

});


// Show posts to edit
if (showPosts) {

    showPosts.addEventListener("click", function(event) {

        event.preventDefault();


        // hide forms
        forms.forEach(form => {
            form.style.display = "none";
        });


        // show posts
        postList.style.display = "block";

    });

}