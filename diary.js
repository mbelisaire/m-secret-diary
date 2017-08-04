$(document).ready( function() {
    $("#goToLogIn").click(function() {
        $("#signUp").toggleClass("hidden");
        $("#ad").toggleClass("hidden");
        $("#logIn").toggleClass("hidden");
    });
    $("#goToSignUp").click(function() {
        $("#logIn").toggleClass("hidden");
        $("#ad").toggleClass("hidden");
        $("#signUp").toggleClass("hidden");
    });

    $( "#diaryPage" ).change(function() {
        saveDiary();
    });

    $( "#diaryPage" ).keyup(function() {
        saveDiary();
    });
});

function saveDiary() {
    $.post("diary.php",
    {
        content: $("#diaryPage").val()
    },
    function(data, status){
    });
}
