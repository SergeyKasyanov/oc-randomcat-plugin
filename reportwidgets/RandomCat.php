<?php namespace SergeyKasyanov\RandomCat\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Illuminate\Support\Facades\Log;
use October\Rain\Support\Facades\Http;
use RuntimeException;

/**
 * RandomCat Report Widget
 */
class RandomCat extends ReportWidgetBase
{
    /**
     * @var string The default alias to use for this widget
     */
    protected $defaultAlias = 'RandomCatReportWidget';

    /**
     * Defines the widget's properties
     *
     * @return array
     */
    public function defineProperties(): array
    {
        return [
            'title' => [
                'title'             => 'backend::lang.dashboard.widget_title_label',
                'default'           => 'Random Cat',
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error',
            ],
        ];
    }

    /**
     * Renders the widget's primary contents.
     *
     * @return string HTML markup supplied by this widget.
     */
    public function render(): string
    {
        try {
            $this->prepareVars();
        } catch (RuntimeException $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('randomcat');
    }

    private function prepareVars(): void
    {
        $res = Http::get('https://aws.random.cat/meow');

        if ($res->code !== 200) {
            Log::error('Cat service answer is not ok :(');
            Log::error($res->body);
            throw new RuntimeException('no cat today :(');
        }

        $data = json_decode($res->body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Json parse error');
            Log::error(json_last_error_msg());
            throw new RuntimeException('no cat today :(');
        }

        $this->vars['url'] = $data['file'];
    }
}
