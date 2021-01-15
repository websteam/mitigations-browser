<?php

namespace Tests\Unit;

use App\Dto\SDOAbstract;
use App\Dto\SDOExternalReference;
use App\Dto\SDOTacticData;
use App\Dto\SDOTechniqueData;
use Exception;
use PHPUnit\Framework\TestCase;

class DTOParsingSDOTest extends TestCase
{
    /**
     * @dataProvider provideTacticData
     * @param array $tacticData
     * @throws Exception
     */
    public function testItCanCreateTacticDataObject(array $tacticData)
    {
        $sdoTacticData = new SDOTacticData([
            'id' => $tacticData['id'],
            'name' => $tacticData['name'],
            'slug' => $tacticData['x_mitre_shortname'],
            'description' => $tacticData['description'],
            'external_references' => array_map(function ($reference) {
                return new SDOExternalReference($reference);
            }, $tacticData['external_references']),
            'modified' => new \DateTime($tacticData['modified']),
            'created' => new \DateTime($tacticData['created'])
        ]);

        $this->assertInstanceOf(SDOAbstract::class, $sdoTacticData);
        $this->assertEquals('x-mitre-tactic--1', $sdoTacticData->id);
        $this->assertEquals('tactic-name', $sdoTacticData->slug);
        $this->assertIsIterable($sdoTacticData->external_references);
        $this->assertInstanceOf(\DateTimeInterface::class, $sdoTacticData->created);
    }

    /**
     * @dataProvider provideTechniqueData
     * @param array $techniqueData
     * @throws Exception
     */
    public function testItCanCreateTechniqueDataObject(array $techniqueData)
    {
        $sdoTechniqueData = new SDOTechniqueData([
            'id' => $techniqueData['id'],
            'name' => $techniqueData['name'],
            'description' => $techniqueData['description'],
            'external_references' => array_map(function ($reference) {
                return new SDOExternalReference($reference);
            }, $techniqueData['external_references']),
            'modified' => new \DateTime($techniqueData['modified']),
            'created' => new \DateTime($techniqueData['created'])
        ]);

        $this->assertEquals($sdoTechniqueData->name, 'Acquire Infrastructure');
        $this->assertInstanceOf(SDOExternalReference::class, $sdoTechniqueData->external_references[0]);
    }

    public function testItCanCreateSubtechniqueDataObject(array $subtechniqueData)
    {

    }

    public function testItCanCreateRelationshipDataObject(array $relationshipData)
    {

    }

    public function testItCanCreateDataObjectCollectionFromDataset()
    {

    }

    public function provideTacticData(): array
    {
        return [
            [
                [
                    "id" => "x-mitre-tactic--1",
                    "type" => "x-mitre-tactic",
                    "name" => "Tactic Name",
                    "x_mitre_shortname" => "tactic-name",
                    "description" => "The adversary is trying to gather data of interest to their goal.\n\nCollection consists of techniques adversaries may use to gather information and the sources information is collected from that are relevant to following through on the adversary's objectives. Frequently, the next goal after collecting data is to steal (exfiltrate) the data. Common target sources include various drive types, browsers, audio, video, and email. Common collection methods include capturing screenshots and keyboard input.",
                    "external_references" => [
                        [
                            "external_id" => "TA0009",
                            "url" => "https://attack.mitre.org/tactics/TA0009",
                            "source_name" => "mitre-attack"
                        ]
                    ],
                    "modified" => "2019-07-19T17:44:53.176Z",
                    "created" => "2018-10-17T00:14:20.652Z"
                ]
            ]
        ];
    }

    public function provideTechniqueData(): array
    {
        return [
            [
                [
                    "external_references" => [
                        [
                            "source_name" => "mitre-attack",
                            "external_id" => "T1583",
                            "url" => "https://attack.mitre.org/techniques/T1583"
                        ],
                        [
                            "source_name" => "TrendmicroHideoutsLease",
                            "description" => "Max Goncharov. (2015, July 15). Criminal Hideouts for Lease: Bulletproof Hosting Services. Retrieved March 6, 2017.",
                            "url" => "https://documents.trendmicro.com/assets/wp/wp-criminal-hideouts-for-lease.pdf"
                        ]
                    ],
                    "object_marking_refs" => [
                        "marking-definition--fa42a846-8d90-4e51-bc29-71d5b4802168"
                    ],
                    "created_by_ref" => "identity--c78cb6e5-0c4b-4611-8297-d1b8b55e40b5",
                    "name" => "Acquire Infrastructure",
                    "description" => "Before compromising a victim, adversaries may buy, lease, or rent infrastructure that can be used during targeting. A wide variety of infrastructure exists for hosting and orchestrating adversary operations. Infrastructure solutions include physical or cloud servers, domains, and third-party web services.(Citation: TrendmicroHideoutsLease) Additionally, botnets are available for rent or purchase.\n\nUse of these infrastructure solutions allows an adversary to stage, launch, and execute an operation. Solutions may help adversary operations blend in with traffic that is seen as normal, such as contact to third-party web services. Depending on the implementation, adversaries may use infrastructure that makes it difficult to physically tie back to them as well as utilize infrastructure that can be rapidly provisioned, modified, and shut down.",
                    "id" => "attack-pattern--0458aab9-ad42-4eac-9e22-706a95bafee2",
                    "type" => "attack-pattern",
                    "kill_chain_phases" => [
                        [
                            "kill_chain_name" => "mitre-attack",
                            "phase_name" => "resource-development"
                        ]
                    ],
                    "modified" => "2020-10-22T17:59:17.606Z",
                    "created" => "2020-09-30T16:37:40.271Z",
                    "x_mitre_version" => "1.0",
                    "x_mitre_is_subtechnique" => false,
                    "x_mitre_detection" => "Consider use of services that may aid in tracking of newly acquired infrastructure, such as WHOIS databases for domain registration information. Much of this activity may take place outside the visibility of the target organization, making detection of this behavior difficult.\n\nDetection efforts may be focused on related stages of the adversary lifecycle, such as during Command and Control.",
                    "x_mitre_platforms" => [
                        "PRE"
                    ]
                ]
            ]
        ];
    }
}
