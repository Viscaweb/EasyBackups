<?php

namespace Reports\Senders;

use Reports\Templates\Template;

interface Sender
{

    public function send(Template $template, $recipient);

}