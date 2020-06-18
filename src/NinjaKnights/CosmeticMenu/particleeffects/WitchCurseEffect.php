<?php
declare(strict_types=1);

namespace NinjaKnights\CosmeticMenu\particleeffects;

use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;
use pocketmine\math\Vector3;

class WitchCurseEffect extends GenericParticle {
    public function __construct(Vector3 $pos) {
        parent::__construct($pos, Particle::TYPE_WITCH_SPELL);
    }
}