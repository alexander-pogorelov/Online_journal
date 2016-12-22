<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 12.11.2016
 * Time: 13:49
 */

namespace Application\Sonata\UserBundle\Entity;


class Journal
{
    const  IS_ABSENT = -1;

    private $id;

    private $lesson;

    private $pupilGroup;

    private $assessment; // оценка по предмету (если "-1", то отсутствует на уроке)

    private $remark; // комментарий к оценке


    public static function getMonthsColspanData($lessonsList) {

        $monthBriefString = 'Янв. Фев. Март Апр. Май Июнь Июль Авг. Сен. Окт. Нояб. Дек.';
        $monthBriefArray = explode(" ", $monthBriefString);
        // получаем массив названий месяцев для всех уроков
        $monthsFromLesson = array_map(function ($lessonsList) use($monthBriefArray) {
            return $monthBriefArray[$lessonsList->getDate()->format('m')-1];
        }, $lessonsList);
        // массив данных: ключ - номер месяца, значение - кол-во повторений
        $monthsColspanData = array_count_values($monthsFromLesson);
        return $monthsColspanData;
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set remark
     *
     * @param string $remark
     *
     * @return Journal
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set assessment
     *
     * @param integer $assessment
     *
     * @return Journal
     */
    public function setAssessment($assessment)
    {
        $this->assessment = $assessment;

        return $this;
    }

    /**
     * Get assessment
     *
     * @return integer
     */
    public function getAssessment()
    {
        return $this->assessment;
    }

    /**
     * Set pupilGroup
     *
     * @param \Application\Sonata\UserBundle\Entity\PupilGroupAssociation $pupilGroup
     *
     * @return Journal
     */
    public function setPupilGroup(\Application\Sonata\UserBundle\Entity\PupilGroupAssociation $pupilGroup = null)
    {
        $this->pupilGroup = $pupilGroup;

        return $this;
    }

    /**
     * Get pupilGroup
     *
     * @return \Application\Sonata\UserBundle\Entity\PupilGroupAssociation
     */
    public function getPupilGroup()
    {
        return $this->pupilGroup;
    }

    /**
     * Set lesson
     *
     * @param \Application\Sonata\UserBundle\Entity\Lesson $lesson
     *
     * @return Journal
     */
    public function setLesson(\Application\Sonata\UserBundle\Entity\Lesson $lesson)
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * Get lesson
     *
     * @return \Application\Sonata\UserBundle\Entity\Lesson
     */
    public function getLesson()
    {
        return $this->lesson;
    }

}
