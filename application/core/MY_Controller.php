<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller {
	
	set_directory($segments[0]);
            $segments = array_slice($segments, 1);

            while (count($segments) > 0 && is_dir(APPPATH.'controllers/'.$this->directory.$segments[0]))
            {
                // Set the directory and remove it from the segment array
                $this->set_directory($this->directory . $segments[0]);
                $segments = array_slice($segments, 1);
            }

            if (count($segments) > 0)
            {
                // Does the requested controller exist in the sub-folder?
                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].'.php'))
                {
                    if ( ! empty($this->routes['404_override']))
                    {
                        $x = explode('/', $this->routes['404_override']);

                        $this->set_directory('');
                        $this->set_class($x[0]);
                        $this->set_method(isset($x[1]) ? $x[1] : 'index');

                        return $x;
                    }
                    else
                    {
                        show_404($this->fetch_directory().$segments[0]);
                    }
                }
            }
            else
            {
                // Is the method being specified in the route?
                if (strpos($this->default_controller, '/') !== FALSE)
                {
                    $x = explode('/', $this->default_controller);

                    $this->set_class($x[0]);
                    $this->set_method($x[1]);
                }
                else
                {
                    $this->set_class($this->default_controller);
                    $this->set_method('index');
                }

                // Does the default controller exist in the sub-folder?
                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.'.php'))
                {
                    $this->directory = '';
                    return array();
                }

            }

            return $segments;
        }


        // If we've gotten this far it means that the URI does not correlate to a valid
        // controller class.  We will now see if there is an override
        if ( ! empty($this->routes['404_override']))
        {
            $x = explode('/', $this->routes['404_override']);

            $this->set_class($x[0]);
            $this->set_method(isset($x[1]) ? $x[1] : 'index');

            return $x;
        }


        // Nothing else to do at this point but show a 404
        show_404($segments[0]);
    }

    function set_directory($dir)
    {
        // Allow forward slash, but don't allow periods.
        $this->directory = str_replace('.', '', $dir).'/';
    }

}
	
	//
	public function pageRenderer($page, array $data){
		$this->load->view('includes/landingPage/header',$data);
		$this->load->view($page);
		$this->load->view('includes/landingPage/footer');
	}

	//landing pages
	public function landingPageRenderer($page, array $data){
		$this->load->view('includes/landingPage/header',$data);
		$this->load->view($page);
		$this->load->view('includes/landingPage/footer');
	}

	
	public function registrarPageRenderer($page, array $data){
		$this->load->view('includes/registrar/header',$data);
		$this->load->view($page);
		$this->load->view('includes/registrar/footer');
	}

	public function studentPageRendere($page, array $data){
		$this->load->view('includes/student/header',$data);
		$this->load->view($page);
		$this->load->view('includes/student/footer');
	}
}
