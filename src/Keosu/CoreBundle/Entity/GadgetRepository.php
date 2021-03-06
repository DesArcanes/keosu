<?php
/************************************************************************
 Keosu is an open source CMS for mobile app
Copyright (C) 2016  Pockeit

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
************************************************************************/
namespace Keosu\CoreBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * GadgetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GadgetRepository extends EntityRepository {

	/***
	 * Find all shared gadget in a zone for an app
	 */
	public function findSharedByZoneAndApp($zone, $appid )
	{
		$qb = $this->_em->createQueryBuilder();
		$qb->select('DISTINCT g');
		$qb->from('Keosu\CoreBundle\Entity\Page', 'a');
		$qb->join('Keosu\CoreBundle\Entity\Gadget','g','WITH','a.appId=?1');
		$qb->where('g.shared=1');
		$qb->andWhere('g.zone=?2');

		$qb->setParameter(1, $appid);
		$qb->setParameter(2, $zone);
		$query = $qb->getQuery();
		$gadgets=$query->getResult();
		
		if (count($gadgets) == 0 ) {
			return null;
		}
		
		//TODO : fix the query to evoid this
		foreach($gadgets as $gadget){
			if($gadget->getPage() != null && $gadget->getPage()->getAppId()==$appid){
				return $gadget;
			}
		}
		return null; 
	}
}

