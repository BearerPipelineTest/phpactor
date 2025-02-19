<?php

namespace Phpactor\Extension\LanguageServerCompletion\Util;

use Phpactor\LanguageServerProtocol\MarkupContent;
use Phpactor\LanguageServerProtocol\MarkupKind;
use Phpactor\LanguageServerProtocol\ParameterInformation;
use Phpactor\LanguageServerProtocol\SignatureHelp;
use Phpactor\LanguageServerProtocol\SignatureInformation;
use Phpactor\Completion\Core\SignatureHelp as PhpactorSignatureHelp;

class PhpactorToLspSignature
{
    public static function toLspSignatureHelp(PhpactorSignatureHelp $phpactorHelp): SignatureHelp
    {
        $signatures = [];
        foreach ($phpactorHelp->signatures() as $phpactorSignature) {
            $parameters = [];
            foreach ($phpactorSignature->parameters() as $phpactorParameter) {
                $parameters[] = new ParameterInformation(
                    $phpactorParameter->label(),
                    new MarkupContent(MarkupKind::MARKDOWN, $phpactorParameter->documentation())
                );
            }

            $signatures[] = new SignatureInformation(
                $phpactorSignature->label(),
                new MarkupContent(MarkupKind::MARKDOWN, $phpactorSignature->documentation() ?? ''),
                $parameters
            );
        }

        return new SignatureHelp($signatures, $phpactorHelp->activeSignature(), $phpactorHelp->activeParameter());
    }
}
