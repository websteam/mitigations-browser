<?php

namespace Tests\Unit;

use App\DTO\ADMAbstract;
use App\DTO\ADMExternalReference;
use App\DTO\ADMRelationshipData;
use App\DTO\ADMSubtechniqueData;
use App\DTO\ADMTacticData;
use App\DTO\ADMTechniqueData;
use PHPUnit\Framework\TestCase;

class DTOParsingADMTest extends TestCase
{
    /**
     * @dataProvider provideTacticData
     * @param array $tacticData
     */
    public function testItCanCreateTacticDataObject(array $tacticData)
    {
        $this->assertTrue(ADMTacticData::matches($tacticData));
        $this->assertFalse(ADMTechniqueData::matches($tacticData));
        $this->assertFalse(ADMSubtechniqueData::matches($tacticData));
        $this->assertFalse(ADMRelationshipData::matches($tacticData));

        $admTacticData = ADMTacticData::fromArray($tacticData);

        $this->assertInstanceOf(ADMAbstract::class, $admTacticData);
        $this->assertEquals('x-mitre-tactic--1', $admTacticData->id);
        $this->assertEquals('tactic-name', $admTacticData->slug);
        $this->assertIsIterable($admTacticData->external_references);
        $this->assertInstanceOf(\DateTimeInterface::class, $admTacticData->created);
    }

    /**
     * @dataProvider provideTechniqueData
     * @param array $techniqueData
     */
    public function testItCanCreateTechniqueDataObject(array $techniqueData)
    {
        $this->assertFalse(ADMTacticData::matches($techniqueData));
        $this->assertTrue(ADMTechniqueData::matches($techniqueData));
        $this->assertFalse(ADMSubtechniqueData::matches($techniqueData));
        $this->assertFalse(ADMRelationshipData::matches($techniqueData));

        $admTechniqueData = ADMTechniqueData::fromArray($techniqueData);

        $this->assertEquals('Acquire Infrastructure', $admTechniqueData->name);
        $this->assertInstanceOf(ADMExternalReference::class, $admTechniqueData->external_references[0]);
    }

    /**
     * @dataProvider provideSubtechniqueData
     * @param array $subtechniqueData
     */
    public function testItCanCreateSubtechniqueDataObject(array $subtechniqueData)
    {
        $this->assertFalse(ADMTacticData::matches($subtechniqueData));
        $this->assertFalse(ADMTechniqueData::matches($subtechniqueData));
        $this->assertTrue(ADMSubtechniqueData::matches($subtechniqueData));
        $this->assertFalse(ADMRelationshipData::matches($subtechniqueData));

        $admSubtechniqueData = ADMSubtechniqueData::fromArray($subtechniqueData);

        $this->assertIsBool($admSubtechniqueData->x_mitre_is_subtechnique);
        $this->assertEquals('Add Office 365 Global Administrator Role', $admSubtechniqueData->name);
        $this->assertStringContainsString('An adversary may add the Global Administrator role to an adversary-controlled account to maintain persistent access to an Office 365 tenant.', $admSubtechniqueData->description);
        $this->assertInstanceOf(ADMExternalReference::class, $admSubtechniqueData->external_references[0]);
    }

    /**
     * @dataProvider provideRelationshipData
     * @param array $relationshipData
     */
    public function testItCanCreateRelationshipDataObject(array $relationshipData)
    {
        $this->assertFalse(ADMTacticData::matches($relationshipData));
        $this->assertFalse(ADMTechniqueData::matches($relationshipData));
        $this->assertFalse(ADMSubtechniqueData::matches($relationshipData));
        $this->assertTrue(ADMRelationshipData::matches($relationshipData));

        $admRelationshipData = ADMRelationshipData::fromArray($relationshipData);

        $this->assertNotNull($admRelationshipData->source_ref);
        $this->assertNotNull($admRelationshipData->target_ref);
        $this->assertEquals('subtechnique-of', $admRelationshipData->relationship_type);
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

    public function provideSubtechniqueData(): array
    {
        return [
            [
                [
                    "external_references" => [
                        [
                            "source_name" => "mitre-attack",
                            "external_id" => "T1098.003",
                            "url" => "https://attack.mitre.org/techniques/T1098/003"
                        ],
                        [
                            "source_name" => "Microsoft Support O365 Add Another Admin, October 2019",
                            "url" => "https://support.office.com/en-us/article/add-another-admin-f693489f-9f55-4bd0-a637-a81ce93de22d",
                            "description" => "Microsoft. (n.d.). Add Another Admin. Retrieved October 18, 2019."
                        ],
                        [
                            "source_name" => "Microsoft O365 Admin Roles",
                            "url" => "https://docs.microsoft.com/en-us/office365/admin/add-users/about-admin-roles?view=o365-worldwide",
                            "description" => "Ako-Adjei, K., Dickhaus, M., Baumgartner, P., Faigel, D., et. al.. (2019, October 8). About admin roles. Retrieved October 18, 2019."
                        ]
                    ],
                    "object_marking_refs" => [
                        "marking-definition--fa42a846-8d90-4e51-bc29-71d5b4802168"
                    ],
                    "created_by_ref" => "identity--c78cb6e5-0c4b-4611-8297-d1b8b55e40b5",
                    "name" => "Add Office 365 Global Administrator Role",
                    "description" => "An adversary may add the Global Administrator role to an adversary-controlled account to maintain persistent access to an Office 365 tenant.(Citation: Microsoft Support O365 Add Another Admin, October 2019)(Citation: Microsoft O365 Admin Roles) With sufficient permissions, a compromised account can gain almost unlimited access to data and settings (including the ability to reset the passwords of other admins) via the global admin role.(Citation: Microsoft O365 Admin Roles) \n\nThis account modification may immediately follow [Create Account](https://attack.mitre.org/techniques/T1136) or other malicious account activity.",
                    "id" => "attack-pattern--2dbbdcd5-92cf-44c0-aea2-fe24783a6bc3",
                    "type" => "attack-pattern",
                    "kill_chain_phases" => [
                        [
                            "kill_chain_name" => "mitre-attack",
                            "phase_name" => "persistence"
                        ]
                    ],
                    "modified" => "2020-03-24T12:40:02.331Z",
                    "created" => "2020-01-19T16:59:45.362Z",
                    "x_mitre_version" => "1.0",
                    "x_mitre_is_subtechnique" => true,
                    "x_mitre_permissions_required" => [
                        "Administrator"
                    ],
                    "x_mitre_detection" => "Collect usage logs from cloud administrator accounts to identify unusual activity in the assignment of roles to those accounts. Monitor for accounts assigned to admin roles that go over a certain threshold of known admins. ",
                    "x_mitre_data_sources" => [
                        "Office 365 audit logs"
                    ],
                    "x_mitre_contributors" => [
                        "Microsoft Threat Intelligence Center (MSTIC)"
                    ],
                    "x_mitre_platforms" => [
                        "Office 365"
                    ]
                ]
            ]
        ];
    }

    public function provideRelationshipData(): array
    {
        return [
            [
                [
                    "created_by_ref" => "identity--c78cb6e5-0c4b-4611-8297-d1b8b55e40b5",
                    "object_marking_refs" => [
                        "marking-definition--fa42a846-8d90-4e51-bc29-71d5b4802168"
                    ],
                    "source_ref" => "attack-pattern--f3d95a1f-bba2-44ce-9af7-37866cd63fd0",
                    "target_ref" => "attack-pattern--35dd844a-b219-4e2b-a6bb-efa9a75995a9",
                    "relationship_type" => "subtechnique-of",
                    "id" => "relationship--e7c8615b-2dd4-42a9-9535-2deed30ea8d7",
                    "type" => "relationship",
                    "modified" => "2019-11-27T14:31:56.861Z",
                    "created" => "2019-11-27T14:31:56.861Z"
                ]
            ]
        ];
    }
}
