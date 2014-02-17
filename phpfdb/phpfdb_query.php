<?php
class PHPFDB_query{
	public $raw_execution_plan;
	public function __construct($sql){
		
		require_once('PHPSqlParser/sql.lex.php');
		require_once('PHPSqlParser/sql.php');
		require_once('PHPSqlParser/query-planner.php');
		require_once('PHPSqlParser/filter-framework.php');
		
		$P = new ParseParser();
		$fh = fopen("temp/test_query.sql", "w");
		fwrite($fh, $sql);
		fclose($fh);
		$S = new Yylex(fopen("temp/test_query.sql", "r")); // you can get one of these using the JLexPHP package
		$P->ParseTrace(fopen("temp/trace", "w"), "");
		
		while ($t = $S->yylex()) {
			$P->Parse(constant('ParseParser::'. $t->type), $t);
		}
		$P->Parse(0);
		/*
		echo "<pre>";
		print_r($P);
		echo "</pre>";
		*/
		echo "<pre>";
		print_r($this->raw_execution_plan);
		echo "</pre>";
		$this->raw_execution_plan = $P->yystack[1]->minor->actions;
	}
}