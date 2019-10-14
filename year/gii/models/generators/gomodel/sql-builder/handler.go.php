<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var \year\gii\models\generators\gomodel\Generator $generator
 * @var string $tableName full table name
 * @var string $className class name for table
 */

//   $generator->tableName
$goColumnsMeta = $generator->columnsMetaData($giiConsolePath) ;

$packageName = 'handlers';
$imports = [] ;

$modelClassName = $modelName = $className ;
$daoServiceName = lcfirst($className).'Service' ;
$controllerName = $className.'Controller' ;

// url path pattern:
$urlBase =  Inflector::camel2id($modelName);
$getUrlPattern = $urlBase .'/{id:[0-9]+}' ;
$queryUrlPattern = $urlBase   ;
$createUrlPattern = $urlBase   ;
$updateUrlPattern = $urlBase .'/{id}'  ;
$deleteUrlPattern = $urlBase .'/{id}'  ;
?>
package handlers

import (
	"dbstair/apps/giisample/models"
	"github.com/gorilla/mux"
	"log"
	"net/http"
)

type (
	// <?= $daoServiceName ?> specifies the interface for the <?= $tableName ?> service needed by <?= lcfirst($controllerName) ?>.
	// 在多层架构中 可以同时适配dao层和service层
	<?= lcfirst($daoServiceName) ?> interface {
		Get(id int) (*models.<?= $className ?>, error)
		Query(offset, limit int) ([]models.<?= $className ?>, error)
		Count() (int, error)
		Create(model *models.<?= $className ?>) (*models.<?= $className ?>, error)
		Update(id int, model *models.<?= $className ?>) (*models.<?= $className ?>, error)
		Delete(id int) (*models.<?= $className ?>, error)
	}

	// <?= $controllerName ?> defines the handlers for the CRUD APIs.
<?= $controllerName ?>  struct {
		service <?= lcfirst($daoServiceName)  ?>
}
)

// Serve<?= Inflector::pluralize($className )?> sets up the routing of <?= $tableName ?> endpoints and the corresponding handlers.
func Serve<?= ucfirst($controllerName) ?>(r *mux.Router /* , service artistService */) {
	h := &<?= lcfirst($controllerName) ?>{ /* service*/ }
	// r := mux.NewRouter()
	// Serve<?= Inflector::pluralize($className )?>  Register the handler functions
	r.HandleFunc("/<?= $getUrlPattern?>}", h.get()).Methods("GET")        // Get model by id
	r.HandleFunc("/<?= $queryUrlPattern?>", h.query()).Methods("GET")                  // list models
	r.HandleFunc("/<?= $createUrlPattern?>", h.create()).Methods("POST")                // create model
	r.HandleFunc("/<?= $updateUrlPattern?>", h.update()).Methods("PUT", "POST")    // update model
	r.HandleFunc("/<?= $deleteUrlPattern?>", h.delete()).Methods("DELETE", "POST") // delete model
}

func (c *<?= lcfirst($controllerName) ?>) get() http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := mux.Vars(r)["id"]
		_, err := w.Write([]byte("get <?=  $tableName ?>!" + id))
		if err != nil {
			log.Println("get Error:", err)
		}
	}
}

func (c *<?= lcfirst($controllerName) ?>) query() http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		_, err := w.Write([]byte("list <?=  $tableName ?>!"))
		if err != nil {
			log.Println("list Error:", err)
		}
	}
}

func (c *<?= lcfirst($controllerName) ?>) create() http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		_, err := w.Write([]byte("create <?=  $tableName ?>!"))
		if err != nil {
			log.Println("update Error:", err)
		}
	}
}

func (c *<?= lcfirst($controllerName) ?>) update() http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := mux.Vars(r)["id"]
		_, err := w.Write([]byte("update <?=  $tableName ?>!" + id))
		if err != nil {
			log.Println("update Error:", err)
		}
	}
}

func (c *<?= lcfirst($controllerName) ?>) delete() http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := mux.Vars(r)["id"]
		_, err := w.Write([]byte("delete <?=  $tableName ?>!" + id))
		if err != nil {
			log.Println("delete Error:", err)
		}
	}
}
