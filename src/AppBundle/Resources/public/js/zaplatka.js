/*GET pupils/{id} 456456456

{
    status: 200,
	body: {
	    UserPupil: {
	        firstname: 'Ffsdghd',
		    lastname: 'Drytty',
		    dateOfBirth: '12-11-2006',
			id: 1
		}
		UserPupil: {
	        firstname: 'Hrtsy',
		    lastname: 'Artyrty',
		    dateOfBirth: '21-07-2004',
			id: 2
		}
		UserPupil: {
	        firstname: 'Gayryath',
		    lastname: 'Kughkj',
		    dateOfBirth: '05-03-2005',
			id: 3
		}
		UserPupil: {
	        firstname: 'Jjtyitu',
		    lastname: 'Hret42',
		    dateOfBirth: '25-09-2004',
			id: 4
		}
		UserPupil: {
	        firstname: 'Hfgjhd',
		    lastname: 'Gewerqa',
		    dateOfBirth: '09-12-2006',
			id: 5
		}
		UserPupil: {
	        firstname: 'Name',
		    lastname: 'surname',
		    dateOfBirth: '14-03-2006',
			id: 6
		}
		UserPupil: {
	        firstname: 'Herter',
		    lastname: 'Hsersw',
		    dateOfBirth: '18-05-2004',
			id: 7
		}
		
	}
}*/


var getMessages = 
{
    status: 200,
	body: {
	    message: [
	        {sender: {
		        name: 'Gggretgr',
		        surname: 'Gdsgse',
				id: 11
		    },
		    message_name: 'sdfjdf',
			message: 'dasfgdrgafgfdsbsdshaer dfshrtghragrf fbsdfjntyjhrttreg retwagdfhaeryea jhrtue5yeraghdfahaer',
			datetime: '1473600345',
			read: 0,
			id: 1},

	        {sender: {
		        name: 'FGfgjhdfj',
		        surname: 'Herwtert',
				id: 12
		    },
		    message_name: 'dfhtghtg',
			message: 'sfhgn rgoiergh eripjh earipjher]9pu wer9uj isgj adfilrear reshjdtyjer efgarhstyhasdf ',
			datetime: '1473759926',
			read: 1,
			id: 2},

			{sender: {
		        name: 'hHDJDTYJDJ',
		        surname: 'FGsfjhsrtjhsrt',
				id: 13
		    },
		    message_name: 'hgghj',
			message: 'dkfgh ruiog heroh regh gwejoo p0 RFEF[SD FDGO JERjyjyujy rt hrt raetyrturt rg awer',
			datetime: '1474774510',
			read: 0,
			id: 3},

	        {sender: {
		        name: 'Gggretgr',
		        surname: 'Gdsgse',
				id: 11
		    },
		    message_name: 'fgjfgj',
			message: 'dfhdrts htfj ykuiloliuktyujaer   wefgdh jydj dfgh sdgh j dyj ytkj ty rt',
			datetime: '1475420781',
			read: 1,
			id: 4}			

		],
				
	}
};


var subjects =        //домашка?
{
    status: 200,
	body: {
		lesson: [ 
		    {date: '1452470400', ball: '8', topic: 'Основные элементы композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram', comment: 'Молодец! Делает Успехи.'},
			{date: '1452729600', ball: '', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453075200', ball: '-1', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453334400', ball: '', topic: 'Реализация идей на плоскости', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453680000', ball: '-1', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453939200', ball: '-1', topic: 'Создание презентаций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454284800', ball: '', topic: 'Применение знаний в проектах', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454544000', ball: '', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454889600', ball: '6', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1455148800', ball: '', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1452470400', ball: '', topic: 'Основные элементы композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram', comment: 'Принёс в школу питарды! Родители, очень хочется с Вами встретиться!'},
			{date: '1452729600', ball: '', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453075200', ball: '-1', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453334400', ball: '', topic: 'Реализация идей на плоскости', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453680000', ball: '-1', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453939200', ball: '', topic: 'Создание презентаций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454284800', ball: '', topic: 'Применение знаний в проектах', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454544000', ball: '', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454889600', ball: '6', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1455148800', ball: '', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
				   {date: '1452470400', ball: '8', topic: 'Основные элементы композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram', comment: 'Молодец! Делает Успехи.'},
			{date: '1452729600', ball: '', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453075200', ball: '-1', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453334400', ball: '', topic: 'Реализация идей на плоскости', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453680000', ball: '-1', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453939200', ball: '-1', topic: 'Создание презентаций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454284800', ball: '', topic: 'Применение знаний в проектах', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454544000', ball: '', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454889600', ball: '6', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1455148800', ball: '', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1452470400', ball: '', topic: 'Основные элементы композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram', comment: 'Принёс в школу питарды! Родители, очень хочется с Вами встретиться!'},
			{date: '1452729600', ball: '', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453075200', ball: '-1', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453334400', ball: '', topic: 'Реализация идей на плоскости', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453680000', ball: '-1', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453939200', ball: '', topic: 'Создание презентаций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454284800', ball: '', topic: 'Применение знаний в проектах', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454544000', ball: '', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454889600', ball: '6', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1455148800', ball: '', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
				    {date: '1452470400', ball: '8', topic: 'Основные элементы композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram', comment: 'Молодец! Делает Успехи.'},
			{date: '1452729600', ball: '', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453075200', ball: '-1', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453334400', ball: '', topic: 'Реализация идей на плоскости', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453680000', ball: '-1', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453939200', ball: '-1', topic: 'Создание презентаций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454284800', ball: '', topic: 'Применение знаний в проектах', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454544000', ball: '', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454889600', ball: '6', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1455148800', ball: '', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1452470400', ball: '', topic: 'Основные элементы композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram', comment: 'Принёс в школу питарды! Родители, очень хочется с Вами встретиться!'},
			{date: '1452729600', ball: '', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453075200', ball: '-1', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453334400', ball: '', topic: 'Реализация идей на плоскости', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453680000', ball: '-1', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1453939200', ball: '', topic: 'Создание презентаций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454284800', ball: '', topic: 'Применение знаний в проектах', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454544000', ball: '', topic: 'Работа с цветом', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1454889600', ball: '6', topic: 'Создание графических декоративных композиций', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			{date: '1455148800', ball: '', topic: 'Выражение мыслей в виде графики', homework: 'http://confluence.it-academy.by:8090/display/STREAM/Class+Diagram'},
			
		]
	}
}

var lessons = 
	{
	    status: 200,
		body: {
			lessons: [
			    'Арт студия',
				'PhotoShop'
			],
			shot_lessons: [
				'APT',
				'PS'],
			period: '|| семестр (январь - май 2017)'

		}
	}


var timetable = 		//расписание
{
    status: 200,
	body: {
		timetable: [
		    {
				day_of_the_week: 2,
				start: '15.00',
				end: '16.20',
				UserTeacher: {
					firstname: 'Т.И.',
					lastname: 'Безрукова',
					id: 1
				},
				classroom: '803',
				lesson: 'Арт студия',
				id: 1
			},
			{
				day_of_the_week: 4,
				start: '14.00',
				end: '15.20',
				UserTeacher: {
					firstname: 'А.М.',
					lastname: 'Колокольцев',
					id: 1
				},
				classroom: '806',
				lesson: 'Addobe Photoshop',
				id: 1
			}
		]
	}
}

/*
GET subjects/{subject_id}
{
    status: 200,
	body: {
		subject: {
			id: 31,
			name: 'name',
			UserTeacher: {
				firstname: '',
				lastname: '',
				id: 41
			}
			message: 'message',
			datetime: <timestamp>
		}

	}
}







// информация по студентам
GET subject/{subject_id}/lessons/{lesson_id}/userpupils
*/