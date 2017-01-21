// Получаем полный URL, включая php-файл экшена (если он есть)
var URL = window.location.protocol + "//" + window.location.host + "/";
var URI = window.location.pathname;

// Получаем первую часть URI
var uriFirstPart = URI.substring(1, (URI.indexOf("/", 2)));

// Модифицируем URL и URI, если используются экшены входа Symfony
if (uriFirstPart == "app_dev.php" || uriFirstPart == "app.php") {
    URL = URL + uriFirstPart + "/";
    var URI = URI.replace("/"+uriFirstPart+"/", "");
} else {
    // Удаляем "/" сначала строки с URI
    URI = URI.substring(1);
}

// разбиваем URI на массив по символу "/"
var uriArray = URI.split('/');
if (uriArray[0] === "pupil" && uriArray[2] === "cabinet") {
    // получаем ID ученика
    var id = uriArray[1];
}

// Получаем полный URL для запроса через REST API
var pupilObjectRestApiUrl = URL + "api/users/" + id + ".json";

// Осуществляем AJAX-запрос
$.ajax({
    type: "GET",
    dataType: "json",
    url: pupilObjectRestApiUrl,
    success: function(data){
        var pupulObject = data;
        var pupilName = pupulObject.firstname + " " + pupulObject.lastname;
        // Добавляем Имя и Фамилию Ученика в кабинет
        document.getElementById("pupil_name").innerHTML = pupilName;
    }
});

$('.settings').click(function() { //скрывает / показывает настройки аккаунта
	$('.hidden_settings').toggle();
});

$('#check_all').children('span').click(function() { //скрывает / показывает выбор checkbox'ов
	$('.check_settings').toggle();
})

$('#more').children('span').click(function() { //скрывает / показывает выбор доп. возможностей
	$('.mark_as').toggle();
})

$('.check_all').click(function() { //всем сообщениям делает checked
	$('.messages').find('input').attr('checked','checked');
})

$('.check_no_one').click(function() { //убирает у всех сообщений checked
	$('.messages').find('input').removeAttr('checked');
})

$('.check_read').click(function() { //всем прочитанным сообщениям делает checked
	$('.message').not('.message_no_read').find('input').attr('checked','checked');
})

$('.check_no_read').click(function() { //всем непрочитанным сообщениям делает checked
	$('.message_no_read').find('input').attr('checked','checked');
})

$('.partition').click(function() { // создаёт вкладки: Сообщения, Дневник, Расписание, Успеваемость.
	$('.partitions').children().removeClass('partition_selected');
	$(this).addClass('partition_selected');
	$('.partition_content').children().hide().eq($('.partition').index(this)).show(); //делает невидимым все блоки в .partition_content, затем отображает блок с таким же индексом, как и нажатая вкладка.

});



if (lessons.status == "200") {
	console.log('create lessons starting');
	var les = lessons.body.lessons;
	for (var i = 0; i < les.length; i++) {
		$('.score_header').append('<div>').children().last().addClass('lesson_name')
			.append('<p>').children().last().text(les[i]);
	}
	$('.lesson_name:first').addClass('lesson_name_active');
}



if (getMessages.status == '200') {
	console.log('create messages starting');
	var mes = getMessages.body.message;
	for (var i = 0; i < mes.length; i++) {
		//console.log(mes[i].sender.name);
		var soon = new Date;
		soon.setTime = mes[i].datetime;
		$('.messages').append('<div>').children().last().addClass('message')//создал div.message
		.append('<input type="checkbox">').children().last().attr('id','mes_check' + i).end().end()
		.append('<label>').children().last().attr('for','mes_check' + i).end().end()
		.append('<p>').children().last().addClass('message_sender').text(mes[i].sender.name).end().end()
		.append('<p>').children().last().addClass('message_name').text(mes[i].message_name).end().end()
		.append('<p>').children().last().addClass('message_content').text(mes[i].message).end().end()
		.append('<p>').children().last().addClass('message_date').text(soon.getUTCFullYear());

		if (mes[i].read == 0) {
			$('.messages').children().last().addClass('message_no_read');
		}
	}
}

if (subjects.status == '200') {
	console.log('create subjects started');
	var subj = subjects.body.lesson;
 
	for(var i = 0; i < subj.length; i++) {
		var soon = new Date(subj[i].date*1000);
		

		var absent = function(y,x) { //проверяет, присутствовал ли ученик на занятии. Необходима, поскольку при отсутствии ученика на занятии, ему ставиться "-1".
			if (x >= 0) {
				return (x)
			}
			else {
				return ('H')
			}
		};

		$('.table_with_raitings').children().children().eq(0).append('<td>').children().last().text('J' + soon.getDate());

		$('.table_with_raitings').children().children().eq(1).append('<td>').children().last().text(absent(0,subj[i].ball));
		//console.log(new Date(subj[i].date*1000));
		
		if (subj[i].comment) { // Если есть комментарии к уроку, показывает их
			$('.table_with_raitings').children().children().eq(1).children().eq(i)
				.append('<p class="comment">').children().last()
				.append('<div class="comment_arrow">').append('<div class="comment_message">').children().last()
				.append('<p>').text(subj[i].comment);
		}

	}

	/*createComments();*/
	absentsAndScores();
	createTableWithHomeWork();
}

$('.comment').click(function() { //отображение / срытите комментария к занятию
	console.log('!!!!');
	$(this).children().toggle();
})

$('.lesson_name').click(function() {// Переключает в Дневнике вкладки с названиями предметов
	console.log('click');
	$('.score_header').children().removeClass('lesson_name_active');
	$(this).addClass('lesson_name_active');
});


function  absentsAndScores() { //вычисляет средний балл и кол-во пропусков

	var absents = 0;
	var how_much_scores = 0;
	var score_summ = 0;


	for (var i = 0; i < subj.length; i++) {

		if (subj[i].ball !== '-1' && subj[i].ball !== '') {
			how_much_scores++;
			score_summ += parseInt(subj[i].ball);
		}
		if (subj[i].ball === '-1') {
			absents++;
		}
		
	}
	$('.average_score').text(Math.round(score_summ/how_much_scores/0.1)*0.1);
	$('.absents').text(absents);

}
	

function createTableWithHomeWork() { //создаёт и заполняет таблицу с домашним заданием
	for (var i = 0; i < subj.length; i++) {
		var dateWithNolik = String((new Date(subj[i].date*1000)).getDate());
		if (dateWithNolik.length < 2) {
			dateWithNolik = '0' + dateWithNolik;
		}
		$('.home_work').children().append('<tr>').children().last()
		.append('<td>').children().last()
			.text(dateWithNolik + '.0' + 
				(1 + new Date(subj[i].date*1000).getMonth()) + '.' + 
				(new Date(subj[i].date*1000)).getFullYear()).end().end()
		.append('<td>').children().last().text(subj[i].topic).end().end()
		.append('<td>').children().last()
			.append('<div>').children().last()
			.append('<a>').children().last().attr('href',subj[i].homework).text(subj[i].homework);
	}
}






if (timetable.status == '200') { //создаёт вкладку Расписание
	console.log('timetable create starting');
	var ttable = timetable.body.timetable;
	var week = ['ноль', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье'];
	for (var i = 0; i < ttable.length; i++) {
		$('.week_timetable').children()
			.append('<tr>').children().last()
				.append('<td>').children().last().text(week[ttable[i].day_of_the_week]).end().end()
				.append('<td>').children().last().text(ttable[i].lesson).end().end()
				.append('<td>').children().last().text(ttable[i].classroom).end().end()
				.append('<td>').children().last().text(ttable[i].start).end().end()
				.append('<td>').children().last().text(ttable[i].end).end().end()
				.append('<td>').children().last().text(ttable[i].UserTeacher.lastname + ' ' + ttable[i].UserTeacher.firstname);
	}
}

if (lessons.status == '200') {
	console.log('create progres starting');
	var progr = lessons.body;
	for (var i = 0; i < progr.lessons.length; i++) {
		$('.progress_table').children().children().eq(1)
			.append('<tr>')
	}
}

$('.td_with_table').css({'max-width':window.innerWidth - 297, 'width': $('.table_with_raitings').width()});// устанавливает максимальную ширину ячейки с таблицей оценок, поскольку calc не срабатывает


/* ПЕРВЫЙ ВАРИАНТ ТАБЛИЦЫ С ОЦЕНКАМИ

if (subjects.status == '200') {
	console.log('create subjects started');
	var subj = subjects.body.lesson;
	var cols = 1;
 
	for(var i = 1; i < subj.length; i++) {
		var soon = new Date(subj[i].date*1000);
		var soon_do = new Date(subj[i-1].date*1000); // создан для сравнения с месяцем в предыдущей дате. Если месяцы разные то создаётся новый столбец.
		var ball;

		var absent = function(y,x) { //проверяет, присутствовал ли ученик на занятии. Необходима, поскольку при отсутствии ученика на занятии, ему ставиться "-1".
			if (x >= 0) {
				return (x)
			}
			else {
				return ('H')
			}
		};

		if (i < 2) {
			$('.table_with_raitings').children().children().first().append('<td>').children().last().text("0" + (1 + new Date(subj[0].date*1000).getMonth()).toFixed()); //создаёт первый стольбец с датой и оценкой. Создан вне цикла, поскольку в цекле при i = 0 создавалось много проблем.
			$('.table_with_raitings').children().children().eq(1).append('<td>').children().last().text(new Date(subj[0].date*1000).getDate());
			$('.table_with_raitings').children().children().eq(2).append('<td>').children().last().text(absent(0,subj[0].ball));
		}

		if (soon.getMonth() != soon_do.getMonth()) { //если месяцы разные
			$('.table_with_raitings').children().children().first().append('<td>').children().last().text("0" + (1 + soon.getMonth()).toFixed());
			cols = 1;
		}
		else { //если месяцы одинаковые
			cols++;
			$('.table_with_raitings').children().children().first().children().last().attr('colspan',cols);
		}

		$('.table_with_raitings').children().children().eq(1).append('<td>').children().last().text(soon.getDate());

		$('.table_with_raitings').children().children().eq(2).append('<td>').children().last().text(absent(0,subj[i].ball));
		//console.log(new Date(subj[i].date*1000));


	}



function createComments() {
	for (var i = 0; i < subj.length; i++) {
		if (subj[i].comment) {
			$('.table_with_raitings').children().children().eq(1).children().eq(i)
				.append('<p class="comment">').children().last()
				.append('<div class="comment_arrow">').append('<div class="comment_message">').children().last()
				.append('<p>').text(subj[i].comment);
		}
	}
};
	*/