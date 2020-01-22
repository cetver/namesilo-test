<?php

namespace App\Domains\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="domain")
 * @ORM\Entity(repositoryClass="App\Domains\Repositories\DomainRepository")
 */
class Domain
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $domain;

    /**
     * @param array $map
     *
     * @return string
     */
    public function topLevelDomain(array $map)
    {
        $data = array_reverse(explode('.', $this->domain));
        if(array_search($data[1] . '.' . $data[0], $map) !== false) {
            $topLevelDomain =  $data[1] . '.' . $data[0];
        } elseif(array_search($data[0], $map) !== FALSE) {
            $topLevelDomain = $data[0];
        } else {
            throw new \RuntimeException('It is impossible to determine the domain');
        }

        return $topLevelDomain;
    }
}
