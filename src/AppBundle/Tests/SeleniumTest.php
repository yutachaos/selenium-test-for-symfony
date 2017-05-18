<?php

namespace AppBundle\Tests\Screen;

use Facebook\WebDriver\Interactions\WebDriverActions;
use Facebook\WebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


/**
 * @property RemoteWebDriver driver
 */
class SeleniumTest extends WebTestCase
{

    const WINDOW_HEIGHT = 768;
    const WINDOW_WIDTH = 1366;
    const SELENIUM_SERVER_HOST = "http://localhost:4444/wd/hub";

    protected $driver;


    /**
     * @test
     * @group chk
     */
    public function testSelenium()
    {
        $inputTask = "test_task";
        $inputMemo = "test_memo";

        $expectTask = "test_task";
        $expectMemo = "test_memo";

        $this->driver = RemoteWebDriver::create(self::SELENIUM_SERVER_HOST, DesiredCapabilities::chrome());
        //windowサイズを指定
        $this->driver->manage()->window()->setSize(new WebDriver\WebDriverDimension(self::WINDOW_WIDTH, self::WINDOW_HEIGHT));

        $this->driver->get("http://test-selenium:8000/todo/");
        $this->driver->findElement(WebDriverBy::id('create'))->click();

        $this->driver->wait(20, 1000)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('body > .container'))
        );

        //フォームへの入力
        $this->driver->findElement(WebDriverBy::id('appbundle_todo_task'))->click();
        $this->driver->getKeyboard()->sendKeys($inputTask);
        $this->driver->findElement(WebDriverBy::id('appbundle_todo_memo'))->click();
        $this->driver->getKeyboard()->sendKeys($inputMemo);

        //submit
        $this->driver->findElement(WebDriverBy::id('create'))->click();
        $this->driver->wait(20, 1000)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('body > .container'))
        );

        //詳細画面に表示されている値の取得
        $actualTask = $this->driver->findElement(WebDriverBy::id('task_text'))->getText();
        $actualMemo = $this->driver->findElement(WebDriverBy::id('memo_text'))->getText();

        //assert
        $this->assertEquals($expectTask, $actualTask);
        $this->assertEquals($expectMemo, $actualMemo);

        $this->driver->quit();
    }

}