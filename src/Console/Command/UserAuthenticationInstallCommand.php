<?php
namespace UserAuthentication\Console\Command;

use Origin\Filesystem\Folder;
use Origin\Console\Command\Command;

class UserAuthenticationInstallCommand extends Command
{
    protected $name = 'user-authentication:install';
    protected $description = '';
    
    const PATH = PLUGINS . DS . 'user_authentication';

    public function initialize(): void
    {
        $this->addOption('force', ['description' => 'Force overwriting files','type' => 'boolean']);
    }
 
    public function execute(): void
    {
        $blacklist = ['UserAuthenticationInstallCommand.php'];

        foreach (['src','tests','public'] as $folder) {
            $files = Folder::list(self::PATH . DS . $folder, ['recursive' => true]);
        
            foreach ($files as $file) {
                if (in_array($file['name'], $blacklist)) {
                    continue;
                }
                $destination = str_replace(
                    [self::PATH . DS . 'src',self::PATH . DS . 'tests',self::PATH . DS . 'public'],
                    [ROOT . DS . 'app',ROOT . DS . 'tests',ROOT  . DS . 'public'],
                    $file['path']
                );
         
                $destination .= DS . $file['name'];
                $contents = $this->getContents($file);
                if ($this->io->createFile($destination, $contents, $this->options('force'))) {
                    $this->io->status('ok', $destination);
                } else {
                    $this->io->status('error', $destination);
                }
            }
        }

        $this->io->nl();
        $this->out([
            '<yellow>Next Steps</yellow>',
            '<white>1. copy the routes that you need from <cyan>config/routes.php</cyan> and remove the plugin setting.</white>',
            '<white>2. copy <cyan>database/schema.php</cyan> into your schema or use <cyan>db:schema:load UserAuthentication.schema</cyan></white>',
        ]);
    }

    private function getContents(string $source): string
    {
        $contents = file_get_contents($source);
        $contents = str_replace('UserAuthentication\\', 'App\\', $contents);
        $contents = str_replace('UserAuthentication.', '', $contents);

        return $contents;
    }
}
