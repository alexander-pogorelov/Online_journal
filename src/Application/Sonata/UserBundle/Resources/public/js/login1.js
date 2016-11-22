
var index;
var attempt = [0,0]; //первый элемент принимает true или false в зависимости от результата валидации, второй - считает количество попыток
var attemptQty = 4;

$.validator.addMethod("regex", function(value, element, regexpr) {
    var clearValue = $.trim(value);//убираю начальные и конечные пробелы
    return regexpr.test(clearValue);
});

$.validator.addMethod("logArr", function(value, element, arg) {
    var clearValueLog = $.trim(value);//убираю начальные и конечные пробелы
    for (var i = 0; i < arg.length; i++ ) {
        if (clearValueLog == arg[i]){
            index = i;
            return index;
        }
    }
    return false;
});

$.validator.addMethod("passArr", function (value, element, arg) {
    var clearValuePass = $.trim(value);//убираю начальные и конечные пробелы
    console.log (index);
    if (arg[index] == clearValuePass ) {
        attempt[0] = true;
        return true;
    }
    else {
        attempt[0] = false;
        return false;
    }
});

$('#enter').validate({
    rules: {
        login: {
            required: true,
            regex: /^[a-z0-9\._\-\/]+\@[a-z]{1,}\.[a-z]{2,}$/,
            logArr: ['','123@mail.ru', '345@gmail.com', 'admin@example.com']
        },
        password: {
            required: true,
            passArr: ['',123, 345, 'admin']
        }
    },
    errorElement: 'p',
    errorClass: 'error',
    messages: {
        login: {
            required: 'Введите логин.',
            regex: 'Проверьте правильность e-mail.',
            logArr: 'Неверный логин. Повторите попытку.'
        },
        password: {
            required: 'Введите пароль.',
            passArr: 'Неверный пароль. Повторите попытку.'
        }
    }
});

document.getElementById('submitButton').addEventListener('click', addVal, false );


function addVal () {
    attempt[1] = attempt[1] + 1;
    if (attempt[1] == attemptQty) {
        $.ajax("unblock.html",
            {
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    document.querySelector('article').innerHTML = data;
                }
            }
        );
    }
}
