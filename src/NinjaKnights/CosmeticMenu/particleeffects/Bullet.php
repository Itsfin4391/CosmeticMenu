<?php
declare(strict_types=1);

namespace NinjaKnights\CosmeticMenu\particleeffects;

use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;
use pocketmine\math\Vector3;

class Bullet extends GenericParticle {
    public function __construct(Vector3 $pos) {
        parent::__construct($pos, Particle::TYPE_SHULKER_BULLET);
    }
}