<?php

namespace IDCI\Bundle\MergeTokenBundle\Tests\Model;

class Author
{
    private $name;
    private $age;
    private $skills;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Author
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param integer
     *
     * @return Author
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return array
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param array $skills
     *
     * @return Author
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

        return $this;
    }


}
