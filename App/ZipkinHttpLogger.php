<?php
namespace App;

use whitemerry\phpkin\Logger\SimpleHttpLogger;

class ZipkinHttpLogger extends SimpleHttpLogger {

	public function __construct($options = []) {
		parent::__construct($options);
	}

	/**
	 * trace 重写方法，启用异步发送
	 * @param    $spans
	 * @return   void
	 */
    public function trace($spans)
    {
        $contextOptions = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => json_encode($spans),
                'ignore_errors' => true
            ]
        ];
        $context = stream_context_create(array_merge_recursive($contextOptions, $this->options['contextOptions']));
        @file_get_contents($this->options['host'] . $this->options['endpoint'], false, $context);

        if (
            !$this->options['muteErrors']
            && (empty($http_response_header) || !$this->validResponse($http_response_header))
        ) {
            throw new LoggerException('Trace upload failed');
        }
    }
}