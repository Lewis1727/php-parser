<?php

class FilmController implements MainController
{

    private $filmManager;

    public function __construct($filmModel)
    {
        $this->filmManager = $filmModel;
        
    }

    public function redirectAction($route="/")
    {
        header("location: $route");
        exit;
    }

    public function indexAction($request)
    {
        return $this->listAction($request);
    }

    public function listAction($request)
    {
        $posts = $this->filmManager->findAllFilms();
        $View = new FilmView($this->filmManager);
        $View->renderView($posts);
    }

    public function findfilmAction($request)
    {
        $films = $this->filmManager->findFilm($request['search']);
        $View = new FilmView($this->filmManager);
        $View->renderView($films);
    }

    public function newfilmAction($request)
    {
        $View = new FilmView($this->filmManager);
        $View->renderView($request);
    }

    public function newfilmsubmittedAction($request)
    {
        $res = null;
        $res = $this->filmManager->addFilm($request['name'], $request['year'], $request['format'], $request['actors']);
        if ($res) {
            $this->redirectAction();
        }
        else {
            $this->redirectAction("/?action=add&error=error");
        }
    }

    public function deleteAction($request)
    {
        $res = null;
        $res = $this->filmManager->deleteFilm($request['id']);
        if ($res) {
            $this->redirectAction();
        }
        else {
            $this->redirectAction("/?action=add&error=error");
        }
    }

  




}