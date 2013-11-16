<?php
namespace Core42\Command\Migration;

use Core42\Command\AbstractCommand;
use Core42\Command\ConsoleOutputInterface;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\ParameterGenerator;

class MakeCommand extends AbstractCommand implements ConsoleOutputInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $migrationDirectory;

    /**
     * @var string
     */
    private $filename;

    /**
     * @throws \Exception
     */
    protected function preExecute()
    {
        $config = $this->getServiceManager()->get("Config");
        if (!is_dir($config['migration']['migration_dir'])) {
            mkdir($config['migration']['migration_dir'], 0777, true);
        }
        $this->migrationDirectory = rtrim($config['migration']['migration_dir'], "/") . "/";

        $date = date("YmdHis");

        $this->className = 'Migration' . $date;
        $this->name = $date;

        $this->filename = $this->migrationDirectory . $this->name . '.php';

        if (file_exists($this->filename)) {
            throw new \Exception("migration file already exists");
        }
    }

    /**
     *
     */
    protected function execute()
    {
        $classGenerator = new ClassGenerator($this->className, "Migrations");
        $classGenerator->addMethod("up", array(
            new ParameterGenerator("migration", '\Core42\Db\Migration\Migration'),
        ));
        $classGenerator->addMethod("down", array(
            new ParameterGenerator("migration", '\Core42\Db\Migration\Migration'),
        ));

        file_put_contents($this->filename, "<?php\n" . $classGenerator->generate());
    }

    /**
     *
     */
    public function publishToConsole()
    {
        /** @var $console \Zend\Console\Adapter\AdapterInterface */
        $console = $this->getServiceManager()->get("Console");

        $console->writeLine("Migration created at {$this->filename}");
    }
}
