<?php

namespace App\Web\Extension;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use gorriecoe\LinkField\LinkField;
use gorriecoe\Link\Models\Link;
use SilverStripe\Forms\EmailField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Assets\File;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\LiteralField;
use Leochenftw\Grid;
use Page;

/**
 * @file SiteConfigExtension
 *
 * Extension to provide Open Graph tags to site config.
 */
class CustomerExtension extends DataExtension
{
    private static $db = [
        'PendingEmail' => 'Varchar(256)',
        'Dob' => 'Date',
        'Gender' => 'Enum("Female,Male,Other")',
        'isStudent' => 'Boolean',
        'Organisation' => 'Varchar',
        'Degree' => 'Enum("Certificate,Diploma,Bachelor,Post-graduate,PhD")',
        'Major' => 'Varchar',
        'TitleLevel' => 'Enum("Entry,Junior,Intermedia,Senior,Lead")',
        'JobCategory' => 'Varchar',
        'WechatID' => 'Varchar',
        'LinkedInLink' => 'Varchar(1024)',
        'Github' => 'Varchar',
    ];

    public function updateAddress($data)
    {
        if (!$this->owner->Addresses()->exists()) {
            $this->owner->createAddressHolder();
        }

        $address = $this->owner->Addresses()->first();
        $address->update($data)->write();
    }

    public function getFullProfile()
    {
        return array_merge(
            $this->owner->jsonSerialize(),
            [
                'dob' => $this->owner->Dob,
                'gender' => $this->owner->Gender,
                'address' => $this->owner->Addresses()->first(),
                'isStudent' => $this->owner->isStudent ? true : false,
                'organisation' => $this->owner->Organisation,
                'degree' => $this->owner->Degree,
                'major' => $this->owner->Major,
                'titleLevel' => $this->owner->TitleLevel,
                'jobCategory' => $this->owner->JobCategory,
                'wechatID' => $this->owner->WechatID,
                'linkedinLink' => $this->owner->LinkedInLink,
                'github' => $this->owner->Github,
            ]
        );
    }
}