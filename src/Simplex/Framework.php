<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class Framework
{
    protected $matcher;
    protected $resolver;
	protected $dispatcher;

    public function __construct($dispatcher, $matcher, $resolver)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
		$this->dispatcher = $dispatcher;
    }

    public function handle(Request $request)
    {
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            $response = call_user_func($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Oooops, we did not find this page!', 404);
        } catch (\Exception $e) {
            $response = new Response('Wow, something is really broken here!', 500);
        }

		// A new event - Response
		$this->dispatcher->dispatch('response', new ResponseEvent($response, $request));
		
		return $response;
    }
}