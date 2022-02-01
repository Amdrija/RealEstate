<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\Stats;

class StatsRepository extends Repository implements \Amdrija\RealEstate\Application\Interfaces\IStatsRepository
{

    public function getStatsByMicroLocation(string $microLocationId): Stats
    {
        $statement = $this->pdo->prepare("SELECT MONTHNAME(Estate.constructionDate) as month, COUNT(*) as sold FROM realEstate.Estate
            JOIN realEstate.Street S on Estate.streetId = S.id
            WHERE microLocationId = :microLocationId AND Estate.constructionDate > DATE_SUB(NOW(), INTERVAL 7 MONTH)
            AND Estate.sold = true
            GROUP BY month
            LIMIT 6;");

        $statement->execute(['microLocationId' => $microLocationId]);

        return $this->createStats($statement->fetchAll());
    }

    public function getStatsByAgency(string $agencyId): Stats
    {
        $statement = $this->pdo->prepare("SELECT MONTHNAME(Estate.constructionDate) as month, COUNT(*) as sold FROM realEstate.Estate
            JOIN realEstate.User on Estate.advertiserId = User.id
            WHERE agencyId = :agencyId AND Estate.constructionDate > DATE_SUB(NOW(), INTERVAL 7 MONTH)
            AND Estate.sold = true
            GROUP BY month
            LIMIT 6;");

        $statement->execute(['agencyId' => $agencyId]);

        return $this->createStats($statement->fetchAll());
    }

    private function createStats(array $rows): Stats {
        $stats = new Stats();
        foreach ($rows as $row) {
            $stats->labels [] = $row['month'];
            $stats->values [] = $row['sold'];
        }

        return $stats;
    }
}