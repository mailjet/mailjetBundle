<?php

namespace spec\Mailjet\MailjetBundle\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Mailjet\MailjetBundle\Manager\ContactMetadataManager;

class SyncContactMetadataCommandSpec extends ObjectBehavior
{
    /**
     * @param  ContactMetadataManager $eventCallbackUrlManager
     */
    public function let(
        ContactMetadataManager $metadataManager
    ) {
        $this->beConstructedWith(
            $metadataManager,
            'mailjet.contact_metadata'
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Mailjet\MailjetBundle\Command\SyncContactMetadataCommand');
    }
}
