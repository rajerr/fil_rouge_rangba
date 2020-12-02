<?php
namespace App\DataPersister;

use App\Entity\ProfileSortie;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
/**
*
*/
class ProfileSortieDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->_entityManager = $entityManager;
    }
    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof ProfileSortie;
    }
    /**
     * @param ProfileSortie $data
     */
    public function persist($data, array $context = [])
    {
        return $data;
    }
    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $data->setStatut(false);
        $apprenants=$data->getApprenants();
        $this->_entityManager->persist($data);
        foreach ($apprenants as $apprenant ) {
            $apprenant->setStatut(true);
            $this->_entityManager->persist($apprenant);
        }
        $this->_entityManager->flush();
        
        return $data;
    }
}