<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 29.11.2016
 * Time: 23:03
 */

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;


class JournalController extends Controller
{
    public function showAction($id = null)
    {
        $request = $this->getRequest();
        // ID предмета
        $subjectId = $request->get($this->admin->getIdParameter());
        // ID группы
        $groupId = $request->get($this->admin->getParent()->getIdParameter());
        // Объект группы
        $objectGroup = $this->admin->getParent()->getObject($groupId);
        // Имя группы
        $groupName = $objectGroup->getGroupName();
        // Объект предмета
        $objectSubject = $this->admin->getObject($subjectId);

        if (!$objectSubject) {
            throw $this->createNotFoundException(sprintf('unable to find the objectSubject with id : %s', $subjectId));
        }
        if (!$objectGroup) {
            throw $this->createNotFoundException(sprintf('unable to find the objectGroup with id : %s', $groupId));
        }

        // Извлекаем список предметов группы для формирования кнопок перехода по предметам
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:GroupIteen');
        $currentGroup = $repository->find($groupId);
        $subjectList = $currentGroup->getSubjects();

        // Извлекаем список уроков группы по текущему предмету, используя кастомный репозиторий
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:Lesson');
        $lessonsList = $repository->findBySubjectAndGroup($subjectId, $groupId);
        //dump($lessonsList);

        // массив месяцев уроков
        $monthsArray = array_map(function ($lessonsList) {
            return $lessonsList->getDate()->format('M');
        }, $lessonsList);
        // массив данных: ключ - номер месяца, значение - кол-во повторений
        $monthsData = array_count_values($monthsArray);

        // Переставляем уроки в обратном порядке для вывода списка последних уроков
        $reverseLessonsList = array_reverse($lessonsList);

        // Извлекаем список всех журналов для учеников группы, используя кастомный репозиторий
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation');
        $journalsData = $repository->findAllJournals($groupId);
        $currentPupilGroupAssociations = $repository->findBy([
            'group' => $currentGroup
        ]);

        // Извлекаем все журналы группы по текущему предмету
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:Journal');
        $journalsByGroupAndBySubject = $repository->findAllByGroupAndBySubject($groupId, $subjectId);

        // Собираем статистику по журналам
        $assessmentCounter = []; $isAbsentCounter = []; $assessmentAmount = [];
        foreach ($currentPupilGroupAssociations as $pga) {
            $assessmentCounter[$pga->getId()] = 0;
            $isAbsentCounter[$pga->getId()] = 0;
            $assessmentAmount[$pga->getId()] = 0;
        }
        foreach ($journalsByGroupAndBySubject as $journal) {
            if ($journal->getAssessment() !== null) {
                if ($journal->getAssessment() === -1) {
                    $isAbsentCounter[$journal->getPupilGroup()->getId()]++;
                } else {
                    $assessmentCounter[$journal->getPupilGroup()->getId()]++;
                    $assessmentAmount[$journal->getPupilGroup()->getId()] += $journal->getAssessment();
                }
            }
        }
        $averageAssessment = [];
        foreach ($currentPupilGroupAssociations as $pga) {
            if ($assessmentCounter[$pga->getId()]) {
            $averageAssessment[$pga->getId()] = $assessmentAmount[$pga->getId()]/$assessmentCounter[$pga->getId()];
            } else {
                $averageAssessment[$pga->getId()] = '';
            }
        }
        $statisticalData = [
            'averageAssessment' => $averageAssessment,
            'assessmentCounter' => $assessmentCounter,
            'isAbsentCounter' => $isAbsentCounter
        ];

        $this->admin->checkAccess('show', $objectSubject);

        $preResponse = $this->preShow($request, $objectSubject);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($objectSubject);

        return $this->render('AppBundle:JournalAdmin:journal_show.html.twig', [
            'action' => 'show',
            'elements' => $this->admin->getShow(),
            'subjectList' => $subjectList,
            'object' => $objectSubject,
            'groupName' => $groupName,
            'groupId' => $groupId,
            'journalsData' => $journalsData,
            'lessonsList' => $lessonsList,
            'reverseLessonsList' => $reverseLessonsList,
            'statisticalData' => $statisticalData,
            'monthsData' => $monthsData,
        ], null);
    }
}