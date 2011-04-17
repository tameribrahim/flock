<?php
/**
 * Created by amalraghav <amal.raghav@gmail.com>
 * Date: 17/04/11
 */
 
namespace Flock\MainBundle\Entity;

class BaseEntity
{
    protected $created_at;

    protected $updated_at;

    /**
     * @orm:prePersist
     */
    private function onPrePersist()
    {
        //TODO set $created_at
    }

    /**
     * @orm:preUpdate
     */
    private function onPreUpdate()
    {
        //TODO set $updated_at
    }    
}
