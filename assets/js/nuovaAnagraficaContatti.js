function scorePassword(pass) {
    var score = 0;
    if (!pass)
        return score;

    // award every unique letter until 5 repetitions
    var letters = new Object();
    for (var i=0; i<pass.length; i++) {
        letters[pass[i]] = (letters[pass[i]] || 0) + 1;
        score += 5.0 / letters[pass[i]];
    }

    // bonus points for mixing it up
    var variations = {
        digits: /\d/.test(pass),
        lower: /[a-z]/.test(pass),
        upper: /[A-Z]/.test(pass),
        nonWords: /\W/.test(pass),
    }

    variationCount = 0;
    for (var check in variations) {
        variationCount += (variations[check] == true) ? 1 : 0;
    }
    score += (variationCount - 1) * 10;

    return parseInt(score);
}

function checkPassStrength(pass) {
    var score = scorePassword(pass);
    if (score > 60)
        return "molto sicura";
    if (score > 40)
        return "sicura";
    if (score >= 20)
        return "poco sicura";

    return "non sicura";
}

function checkPassColor(pass) {
    var score = scorePassword(pass);
    if (score > 60) {
      $("#strength_score").removeClass('bar-warning');
      $("#strength_score").removeClass('bar-danger');
      $("#strength_score").addClass('bar-success');
    } else if (score > 40) {
      $("#strength_score").removeClass('bar-danger');
      $("#strength_score").removeClass('bar-success');
      $("#strength_score").addClass('bar-warning');
    } else  {
      $("#strength_score").removeClass('bar-success');
      $("#strength_score").removeClass('bar-warning');
      $("#strength_score").addClass('bar-danger');
    }
}

$(document).ready(function() {
    $("#inputPassword").on("keypress keyup keydown", function() {
        var pass = $(this).val();
        $("#strength_human").text(checkPassStrength(pass));
        $("#strength_score").css({ "width": scorePassword(pass) + '%'});
        checkPassColor(pass);
    });
});