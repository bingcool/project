<?php
namespace App;

use whitemerry\phpkin\Tracer;
use whitemerry\phpkin\Endpoint;
use whitemerry\phpkin\Span;
use whitemerry\phpkin\Identifier\SpanIdentifier;
use whitemerry\phpkin\Identifier\TraceIdentifier;
use whitemerry\phpkin\AnnotationBlock;
use whitemerry\phpkin\TracerInfo;
use whitemerry\phpkin\Logger\LoggerException;
use App\ZipkinHttpLogger;

class ZipkinHander {

		/**
		 * $instance
		 * @var [type]
		 */
		private static $instance;

		/**
		 * getInstance 
		 * @param    $args
		 * @return   mixed
		 */
	    public static function getInstance(...$args) {
	        if(!isset(self::$instance)){
	            self::$instance = new static(...$args);
	        }
	        return self::$instance;
	    }

	    /**
	     * $logger 日志发送对象
	     * @var null
	     */
	    public $logger = null;

	    /**
	     * $endpoint 
	     * @var null
	     */
	    public $endpoint = null;

	    public $tracer = null;

		/**
		 * __construct 
		 */
		public function __construct($zipkin_host, $zipkin_port = 80, $muteErrors = true, $contextOptions = [], $endpoint = '/api/v1/spans') {
			if(strpos($zipkin_host, 'http://') !== false || strpos($zipkin_host, 'https://') !== false) {
				$this->logger= new ZipkinHttpLogger(['host' => $zipkin_host.":".$zipkin_port, 'endpoint'=>$endpoint, 'muteErrors' => $muteErrors, 'contextOptions'=>$contextOptions]);
			}else {
				throw new LoggerException('zipkin_host require a scheme of http or https');
			}
		}

		/**
		 * setEndpoint 创建本地的服务端
		 * @param    string  $local_servicename
		 * @param    string  $local_ip
		 * @param    int     $port
		 */
		public function setEndpoint($local_servicename, $local_ip, $local_port) {
			$this->endpoint = new Endpoint($local_servicename, $local_ip, $local_port);
		}


		/**
		 * setTracer 创建追踪实例
		 * @param 本次请求的
		 */
		public function setTracer($local_span, $is_back = false) {
			/**
		 	* Read headers
		 	*/
			$traceId = null;

			if(!empty($_SERVER['HTTP_X_B3_TRACEID'])) {
			    $traceId = new TraceIdentifier($_SERVER['HTTP_X_B3_TRACEID']);
			}

			$traceSpanId = null;
			if (!empty($_SERVER['HTTP_X_B3_SPANID'])) {
			    $traceSpanId = new SpanIdentifier($_SERVER['HTTP_X_B3_SPANID']);
			}

			$isSampled = null;
			if(!empty($_SERVER['HTTP_X_B3_SAMPLED'])) {
			    $isSampled = (bool) $_SERVER['HTTP_X_B3_SAMPLED'];
			}

			$this->tracer = new Tracer($local_span, $this->endpoint, $this->logger, $isSampled, $traceId, $traceSpanId);

			!$is_back && $this->tracer->setProfile(Tracer::BACKEND);

		}
		
		/**
		 * begainSpan 
		 * @return  mixed
		 */
		public function begainSpan() {
			$requestStart = zipkin_timestamp();

			$spanId = new SpanIdentifier();

			return [$requestStart, $spanId];
		}


		/**
		 * afterSpan 
		 * @param    array  $begainSpanInfo
		 * @param    array  $remote_endpoint_info
		 * @param    string $remote_span_name
		 * @return   void
		 */
		public function afterSpan(array $begainSpanInfo, array $remote_endpoint_info, string $remote_span_name) {
			list($requestStart, $spanId) = $begainSpanInfo;

			list($remote_endpoint_servicename, $ip, $port) = $remote_endpoint_info;
			
			$endpoint = new Endpoint($remote_endpoint_servicename, $ip, $port);

			$annotationBlock = new AnnotationBlock($endpoint, $requestStart);
			$span = new Span($spanId, $remote_span_name, $annotationBlock);
			// Add span to Zipkin
			$this->tracer->addSpan($span);
		}

		public function getTraceId() {
			return TracerInfo::getTraceId();
		}

		public function getTraceSpanId() {
			return TracerInfo::getTraceSpanId();
		}

		public function isSampled() {
			return (int)TracerInfo::isSampled();
		}

		/**
		 * trace 追踪
		 * @param    {String}
		 * @return   [type]        [description]
		 */
		public function trace() {

			$this->tracer->trace();
		}
		
}