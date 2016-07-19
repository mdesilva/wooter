define({ "api": [
  {
    "type": "get",
    "url": "api/authenticate",
    "title": "GET",
    "version": "1.0.0",
    "name": "getAuthenticatedUser",
    "group": "Authenticate",
    "description": "<p>Authenticates a user</p>",
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'user' => User Object\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TokenExpiredException",
            "description": ""
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": ""
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TokenInvalidException",
            "description": ""
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "JWTException",
            "description": ""
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/AuthenticateController.php",
    "groupTitle": "Authenticate"
  },
  {
    "type": "post",
    "url": "api/award",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "Awards",
    "permission": [
      {
        "name": "admin"
      }
    ],
    "description": "<p>Creates a new Award</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the user</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>Award</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'name' => 'MVP',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Award/AwardsController.php",
    "groupTitle": "Awards",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "UserIsNotAdmin",
            "description": "<p>The user is not an admin.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserIsNotAdmin",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"The user is not an admin\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/award/:awardId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "Awards",
    "permission": [
      {
        "name": "admin"
      }
    ],
    "description": "<p>Deletes the award</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "awardId",
            "description": "<p>Id of the award information to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Award/AwardsController.php",
    "groupTitle": "Awards",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "AwardNotFound",
            "description": "<p>The <code>id</code> of the Award was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-AwardNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The award was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/award/:awardId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "Awards",
    "permission": [
      {
        "name": "admin"
      }
    ],
    "description": "<p>Gets award information</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "awardId",
            "description": "<p>Id of the Award</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'name' => 'MVP',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Award/AwardsController.php",
    "groupTitle": "Awards",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "AwardNotFound",
            "description": "<p>The <code>id</code> of the Award was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-AwardNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The award was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/award/:awardId",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "Awards",
    "permission": [
      {
        "name": "admin"
      }
    ],
    "description": "<p>Updates the award</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "awardId",
            "description": "<p>Award id of the award to update</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "source",
            "description": "<p>Source path of the photo</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the photo</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'name' => 'MVP',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Award/AwardsController.php",
    "groupTitle": "Awards",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "AwardNotFound",
            "description": "<p>The <code>id</code> of the Award was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-AwardNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The award was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/division",
    "title": "Create",
    "name": "Create",
    "group": "Division",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new Division for a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>ID of the league to add the division to</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>The name of the division</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>Division</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'league_id' => '6',\n         'name' => 'First Division',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Division/DivisionsController.php",
    "groupTitle": "Division",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/division/:divisionId",
    "title": "Delete",
    "name": "Delete",
    "group": "Division",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the league division</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "division_id",
            "description": "<p>of the league division to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Division/DivisionsController.php",
    "groupTitle": "Division",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "DivisionNotFound",
            "description": "<p>The <code>id</code> of the division was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "DivisionNotBelongToUser",
            "description": "<p>The user do not have access to the division</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-DivisionNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The division was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "DivisionNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this division\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/division/:divisionId",
    "title": "Read",
    "name": "Read",
    "group": "Division",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets a league division</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "division_id",
            "description": "<p>Id of the Division</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'league_id' => '6',\n         'name' => 'First Division',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Division/DivisionsController.php",
    "groupTitle": "Division",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "DivisionNotFound",
            "description": "<p>The <code>id</code> of the division was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-DivisionNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The division was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/division/:leagueId",
    "title": "Update",
    "name": "Update",
    "group": "Division",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the league division</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "division_id",
            "description": "<p>League id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>The new name for the division</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'league_id' => '6',\n         'name' => 'First Division',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Division/DivisionsController.php",
    "groupTitle": "Division",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "DivisionNotFound",
            "description": "<p>The <code>id</code> of the division was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-DivisionNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The division was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/svg/:file/:fromColor/:toColor",
    "title": "Request a modifed svg file",
    "name": "GetSVG",
    "group": "Files",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "file",
            "description": "<p>Path to the svg file.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "fromColor",
            "description": "<p>Color who will be replaced</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "toColor",
            "description": "<p>Color who will be stored instead fromColor</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example get file:",
          "content": "api/svg/icons.leagues.person",
          "type": "string"
        },
        {
          "title": "Example get file with other color (default color are #000):",
          "content": "api/svg/icons.leagues.person/00adf2",
          "type": "string"
        },
        {
          "title": "Example get file with all colors #fff changed to #00adf2:",
          "content": "api/svg/icons.leagues.person/fff/00adf2/",
          "type": "string"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "firstname",
            "description": "<p>Firstname of the User.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "lastname",
            "description": "<p>Lastname of the User.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Files/SVG.php",
    "groupTitle": "Files"
  },
  {
    "type": "post",
    "url": "api/games",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "Game",
    "description": "<p>Creates a Game</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array containing data that belongs to the newly created game</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => $game_id,\n                    'game_venue' => $game_venue,\n                    'location' => $game_location,\n                    'datetime' => $game_time,\n                    'date' => $game_date,\n                    'stage_id' => $game_stage_id,\n                    'stage_type' => $game_stage_type,\n                    'competition_id' => $game_competition_id,\n                    'competition_type' => $game_competition_type,\n                    'organization_id' => $game_organization_id,\n                    'organization_type' => $game_organization_type,\n                    'sport' => $game_sport,\n                    'home_team' => $game_home_team,\n                    'visiting_team' => $game_visiting_team,\n                    'home_team_id' => $game_home_team_id,\n                    'visiting_team_id' => $game_visiting_team_id,\n                    'home_team_score' => $game_home_team_score,\n                    'visiting_team_score' => $game_visiting_team_score,\n                    'home_team_win' => $game_home_team_win,\n                    'visiting_team_win' => $game_visiting_team_win,\n                    'home_team_loss' => $game_home_team_loss,\n                    'visiting_team_loss' => $game_visiting_team_loss,\n                    'home_team_draw' => $game_home_team_draw,\n                    'visiting_team_draw' => $game_visiting_team_draw,\n                    'home_team_logo' => $game_home_team_logo,\n                    'home_team_logo_id' => $game_home_team_logo_id,\n                    'visiting_team_logo' => $game_visiting_team_logo,\n                    'visiting_team_logo_id' => $game_visiting_team_logo_id,\n                    'week' => $game_week,\n                    'time' => $game_time,\n                    'day' => $game_time_day,\n                    'month' => $game_time_month,\n                    'year' => $game_time_year,\n                    'hour' => $game_time_hour,\n                    'minute' => $game_time_minute,\n                    'second' => $game_time_second,\n                    'created_at' => $game_created_at,\n                    'updated_at' => $game_updated_at,\n                    'scored' => $game_scored,\n                    'game_status' => $game_status\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "home_team_id",
            "description": "<p>The id of the home team of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "visiting_team_id",
            "description": "<p>The id of the visiting team of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "game_venue_id",
            "description": "<p>The id of the venue where the game will take place</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport_id",
            "description": "<p>The id of the sport of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "stage_id",
            "description": "<p>The id of the stage that the game belongs to</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "stage_type",
            "description": "<p>The type of the stage that tge game belongs to</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "time",
            "description": "<p>The scheduled time of the game</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Game/GamesController.php",
    "groupTitle": "Game"
  },
  {
    "type": "delete",
    "url": "api/games/:gameId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "Game",
    "description": "<p>Deletes a Game</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "The",
            "description": "<p>id of the deleted game</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\" => 1\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "gameId",
            "description": "<p>The id of the game to delete</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Game/GamesController.php",
    "groupTitle": "Game"
  },
  {
    "type": "get",
    "url": "api/games/:gameId",
    "title": "Show",
    "version": "1.0.0",
    "name": "Show",
    "group": "Game",
    "description": "<p>Returns a Game</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array with data belonging to a game</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => $game_id,\n                    'game_venue' => $game_venue,\n                    'location' => $game_location,\n                    'datetime' => $game_time,\n                    'date' => $game_date,\n                    'stage_id' => $game_stage_id,\n                    'stage_type' => $game_stage_type,\n                    'competition_id' => $game_competition_id,\n                    'competition_type' => $game_competition_type,\n                    'organization_id' => $game_organization_id,\n                    'organization_type' => $game_organization_type,\n                    'sport' => $game_sport,\n                    'home_team' => $game_home_team,\n                    'visiting_team' => $game_visiting_team,\n                    'home_team_id' => $game_home_team_id,\n                    'visiting_team_id' => $game_visiting_team_id,\n                    'home_team_score' => $game_home_team_score,\n                    'visiting_team_score' => $game_visiting_team_score,\n                    'home_team_win' => $game_home_team_win,\n                    'visiting_team_win' => $game_visiting_team_win,\n                    'home_team_loss' => $game_home_team_loss,\n                    'visiting_team_loss' => $game_visiting_team_loss,\n                    'home_team_draw' => $game_home_team_draw,\n                    'visiting_team_draw' => $game_visiting_team_draw,\n                    'home_team_logo' => $game_home_team_logo,\n                    'home_team_logo_id' => $game_home_team_logo_id,\n                    'visiting_team_logo' => $game_visiting_team_logo,\n                    'visiting_team_logo_id' => $game_visiting_team_logo_id,\n                    'week' => $game_week,\n                    'time' => $game_time,\n                    'day' => $game_time_day,\n                    'month' => $game_time_month,\n                    'year' => $game_time_year,\n                    'hour' => $game_time_hour,\n                    'minute' => $game_time_minute,\n                    'second' => $game_time_second,\n                    'created_at' => $game_created_at,\n                    'updated_at' => $game_updated_at,\n                    'scored' => $game_scored,\n                    'game_status' => $game_status\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "gameId",
            "description": "<p>The id of the game to be returned</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Game/GamesController.php",
    "groupTitle": "Game"
  },
  {
    "type": "put",
    "url": "api/games/:gameId",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "Game",
    "description": "<p>Updates a Game</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array containing data that belongs to the updated game</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => $game_id,\n                    'game_venue' => $game_venue,\n                    'location' => $game_location,\n                    'datetime' => $game_time,\n                    'date' => $game_date,\n                    'stage_id' => $game_stage_id,\n                    'stage_type' => $game_stage_type,\n                    'competition_id' => $game_competition_id,\n                    'competition_type' => $game_competition_type,\n                    'organization_id' => $game_organization_id,\n                    'organization_type' => $game_organization_type,\n                    'sport' => $game_sport,\n                    'home_team' => $game_home_team,\n                    'visiting_team' => $game_visiting_team,\n                    'home_team_id' => $game_home_team_id,\n                    'visiting_team_id' => $game_visiting_team_id,\n                    'home_team_score' => $game_home_team_score,\n                    'visiting_team_score' => $game_visiting_team_score,\n                    'home_team_win' => $game_home_team_win,\n                    'visiting_team_win' => $game_visiting_team_win,\n                    'home_team_loss' => $game_home_team_loss,\n                    'visiting_team_loss' => $game_visiting_team_loss,\n                    'home_team_draw' => $game_home_team_draw,\n                    'visiting_team_draw' => $game_visiting_team_draw,\n                    'home_team_logo' => $game_home_team_logo,\n                    'home_team_logo_id' => $game_home_team_logo_id,\n                    'visiting_team_logo' => $game_visiting_team_logo,\n                    'visiting_team_logo_id' => $game_visiting_team_logo_id,\n                    'week' => $game_week,\n                    'time' => $game_time,\n                    'day' => $game_time_day,\n                    'month' => $game_time_month,\n                    'year' => $game_time_year,\n                    'hour' => $game_time_hour,\n                    'minute' => $game_time_minute,\n                    'second' => $game_time_second,\n                    'created_at' => $game_created_at,\n                    'updated_at' => $game_updated_at,\n                    'scored' => $game_scored,\n                    'game_status' => $game_status\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "gameId",
            "description": "<p>The id of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "home_team_id",
            "description": "<p>The id of the home team of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "visiting_team_id",
            "description": "<p>The id of the visiting team of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "game_venue_id",
            "description": "<p>The id of the venue where the game will take place</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport_id",
            "description": "<p>The id of the sport of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "stage_id",
            "description": "<p>The id of the stage that the game belongs to</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "stage_type",
            "description": "<p>The type of the stage that tge game belongs to</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "time",
            "description": "<p>The scheduled time of the game</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Game/GamesController.php",
    "groupTitle": "Game"
  },
  {
    "type": "post",
    "url": "api/games/:gameId/player-stats",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "Game_Stats",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Creates the stats of a game</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "gameId",
            "description": "<p>The id of the game that the stats will belong to</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "method",
            "description": "<p>The method that was used to save the stats of the game.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport",
            "description": "<p>The sport of the game that the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "type",
            "description": "<p>The type of the stats</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "verbose",
            "description": "<p>Notifies the api whether or not to return a verbose response.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "request",
            "description": "<p>Object containing the stats of the game</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>GameStats</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n                'player_id' => 123,\n                'team_id' => 14,\n                'name' => 'Michael Jordan',\n                'jersey' => 23,\n                'active' => 1,\n                'activate' => 0,\n                'deactivate' => 0,\n                'minutes' => 0,\n                'PTS' => 0,\n                '3FG' => 0,\n                '3FGA' => 0,\n                'AST' => 0,\n                'BLK' => 0,\n                'FG' => 0,\n                'FGA' => 0,\n                'FL' => 0,\n                'FT' => 0,\n                'FTA' => 0,\n                'STL' => 0,\n                'TURN' => 0,\n                'OFFRB' => 0,\n                'DEFRB' => 0\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Game/GameStatsController.php",
    "groupTitle": "Game_Stats"
  },
  {
    "type": "delete",
    "url": "api/games/:gameId/player-stats",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "Game_Stats",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Deletes the stats of a game</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "gameId",
            "description": "<p>The id of the game that the stats will belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport",
            "description": "<p>The sport of the game that the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "type",
            "description": "<p>The type of the stats</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>GameStats</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 1\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Game/GameStatsController.php",
    "groupTitle": "Game_Stats"
  },
  {
    "type": "get",
    "url": "api/games/:gameId/player-stats",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "group": "Game_Stats",
    "description": "<p>Returns the stats for a Game</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "gameId",
            "description": "<p>The id of the game that the returned stats should belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "offset",
            "description": "<p>The offset value of the request.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "limit",
            "description": "<p>The limit amount of stats to return.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "order_by",
            "description": "<p>The parameter to order that stats by.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "order_direction",
            "description": "<p>The order direction of the stats.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport",
            "description": "<p>The name of the sport of the stats to return.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "type",
            "description": "<p>The type of stats to return.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "verbose",
            "description": "<p>Notifies the api whether pr not to return a verbose response.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "player_id",
            "description": "<p>The id of the player that the returned stats should belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "pick",
            "description": "<p>The index pf the stats to return.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>GameStats</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'id' => 1,\n                    'player_id' => 123,\n                    'team_id' => 14,\n                    'name' => 'Michael Jordan',\n                    'jersey' => 23,\n                    'active' => 1,\n                    'activate' => 0,\n                    'deactivate' => 0,\n                    'minutes' => 0,\n                    'PTS' => 0,\n                    '3FG' => 0,\n                    '3FGA' => 0,\n                    'AST' => 0,\n                    'BLK' => 0,\n                    'FG' => 0,\n                    'FGA' => 0,\n                    'FL' => 0,\n                    'FT' => 0,\n                    'FTA' => 0,\n                    'STL' => 0,\n                    'TURN' => 0,\n                    'OFFRB' => 0,\n                    'DEFRB' => 0\n         },\n         {\n             'id' => 2,\n             'player_id' => 53,\n             'team_id' => 5,\n             'jersey' => '2',\n             'PTS' => 0,\n             '3FG' => 0,\n             '3FGA' => 0,\n             'AST' => 0,\n             'BLK' => 0,\n             'FG' => 0,\n             'FG_percent' => 0,\n             'FGA' => 0,\n             'FL' => 0,\n             'FT' => 0,\n             'FTA' => 0,\n             'RBO' => 0,\n             'RBT' => 0,\n             'STL' => 0,\n             'TURN' => 0\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Game/GameStatsController.php",
    "groupTitle": "Game_Stats"
  },
  {
    "type": "post",
    "url": "api/setLanguage",
    "title": "Setting Website Language",
    "name": "Update_Language",
    "group": "Language",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "language",
            "defaultValue": "en, es",
            "description": "<p>Language parameter to set language;</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/ResponseController.php",
    "groupTitle": "Language"
  },
  {
    "type": "post",
    "url": "api/leagues",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create_a_new_league",
    "group": "League",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Creates a new league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the organization</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>Phone of the organization</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "sport_id",
            "description": "<p>ID of the sport of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "url",
            "description": "<p>URL</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": true,
            "field": "dream_league",
            "description": "<p>Whether the league is dream_league (Belongs to DreamLeagues)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "instagram",
            "description": "<p>Instagram of the organization</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "facebook",
            "description": "<p>Facebook of the organization</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "pinterest",
            "description": "<p>Pinterest of the organization</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "google",
            "description": "<p>Google of the organization</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "twitter",
            "description": "<p>Twitter of the organization</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n             'id' => 1,\n             'archived' => 0,\n             'organization_id' => 1,\n             'sport_id' => 1,\n             'organization_name' => 'LFP',\n             'organization_email' => 'support@lfp.es',\n             'name' => 'LFP',\n             'dream_league' => 1,\n             'basics' => $league_basics,\n             'details' => $league_details,\n             'locations' => $league_locations,\n             'seasons' => $league_seasons,\n             'divisions' => $league_divisions,\n             'photos' => $league_photos,\n             'videos' => $league_videos,\n             'qnapVideos' => $league_qnapVideos,\n             'game_venues' => $league_game_venues,\n             'sport' => $sport,\n         ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationsController.php",
    "groupTitle": "League",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "UserHasNoOrganization",
            "description": "<p>The user has not an organization</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserHasNoOrganization:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"The user has not an organization\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Deletes a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>ID of the league to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationsController.php",
    "groupTitle": "League",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League",
    "description": "<p>Returns an array of all the leagues that matches the filter parameters</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array with all the leagues.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => 1,\n             'archived' => 0,\n             'organization_id' => 1,\n             'sport_id' => 1,\n             'organization_name' => 'LFP',\n             'organization_email' => 'support@lfp.es',\n             'name' => 'LFP',\n             'dream_league' => 1,\n             'basics' => $league_basics,\n             'details' => $league_details,\n             'locations' => $league_locations,\n             'seasons' => $league_seasons,\n             'divisions' => $league_divisions,\n             'photos' => $league_photos,\n             'videos' => $league_videos,\n             'qnapVideos' => $league_qnapVideos,\n             'game_venues' => $league_game_venues,\n             'sport' => $sport,\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "name",
            "description": "<p>Name of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "min_age",
            "description": "<p>Minimum age of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "max_age",
            "description": "<p>Maximum age of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "zip",
            "description": "<p>Zip code of the location</p>"
          },
          {
            "group": "Parameter",
            "type": "decimal",
            "optional": true,
            "field": "longitude",
            "description": "<p>Longitude where the league is located</p>"
          },
          {
            "group": "Parameter",
            "type": "decimal",
            "optional": true,
            "field": "latitude",
            "description": "<p>Latitude where the league is located</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "sport_id",
            "description": "<p>ID of the sport to search for</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "limit",
            "description": "<p>Limit of results</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationsController.php",
    "groupTitle": "League",
    "error": {
      "fields": {
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "UserHasNoOrganization",
            "description": "<p>The user has not an organization</p>"
          }
        ],
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserHasNoLeagues",
            "description": "<p>The user has not any leagues</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserHasNoOrganization:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"The user has not an organization\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserHasNoLeagues",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The user has not any leagues\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League",
    "description": "<p>Gets a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n             'id' => 1,\n             'archived' => 0,\n             'organization_id' => 1,\n             'sport_id' => 1,\n             'organization_name' => 'LFP',\n             'organization_email' => 'support@lfp.es',\n             'name' => 'LFP',\n             'dream_league' => 1,\n             'basics' => $league_basics,\n             'details' => $league_details,\n             'locations' => $league_locations,\n             'seasons' => $league_seasons,\n             'divisions' => $league_divisions,\n             'photos' => $league_photos,\n             'videos' => $league_videos,\n             'qnapVideos' => $league_qnapVideos,\n             'game_venues' => $league_game_venues,\n             'sport' => $sport,\n         ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationsController.php",
    "groupTitle": "League",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/leagues/:leagueId",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "League",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Updates the league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>ID of the league to update</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the league</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n             'id' => 1,\n             'archived' => 0,\n             'organization_id' => 1,\n             'sport_id' => 1,\n             'organization_name' => 'LFP',\n             'organization_email' => 'support@lfp.es',\n             'name' => 'LFP',\n             'dream_league' => 1,\n             'basics' => $league_basics,\n             'details' => $league_details,\n             'locations' => $league_locations,\n             'seasons' => $league_seasons,\n             'divisions' => $league_divisions,\n             'photos' => $league_photos,\n             'videos' => $league_videos,\n             'qnapVideos' => $league_qnapVideos,\n             'game_venues' => $league_game_venues,\n             'sport' => $sport,\n         ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationsController.php",
    "groupTitle": "League",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/league/:leagueId/league_basics",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Basics",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new League Basics for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league to save the basics to</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sport_id",
            "description": "<p>Sport id. From the Sports list.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "min_age",
            "description": "<p>Minimum age allowed in the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "max_age",
            "description": "<p>Maximum age allowed in the league</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<p>Gender of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "logo",
            "description": "<p>Logo of the league</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationBasics</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n         'league_id' => '6',\n         'sport_id' => '4',\n         'min_age' => '14',\n         'max_age' => '18',\n         'gender' => 'female',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationBasicsController.php",
    "groupTitle": "League_Basics",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/league/:leagueId/league_basics",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Basics",
    "description": "<p>Returns the basic information for the requested league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the League</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n         'league_id' => '6',\n         'sport_id' => '4',\n         'min_age' => '14',\n         'max_age' => '18',\n         'gender' => 'female',\n         'sport' => [\n               'name' => 'Football',\n               'id' => '2',\n         ],\n         'logo' => [\n               'mime_type' => 'image/jpg',\n               'extension' => 'jpg',\n               'size' => '24353',\n               'file_path' => '/public/image.jpg',\n               'thumbnail_path' => '/public/image-thumb.jpg',\n               'file_name' => 'Real Madrid Official Photo',\n         ],\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationBasicsController.php",
    "groupTitle": "League_Basics"
  },
  {
    "type": "put",
    "url": "api/league/:leagueId/league_basics",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "League_Basics",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the league basics</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the League to update</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sport_id",
            "description": "<p>Sport id. From the Sports list.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "min_age",
            "description": "<p>Minimum age allowed in the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "max_age",
            "description": "<p>Maximum age allowed in the league</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<p>Gender of the league</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n         'league_id' => '6',\n         'sport_id' => '4',\n         'min_age' => '14',\n         'max_age' => '18',\n         'gender' => 'female',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationBasicsController.php",
    "groupTitle": "League_Basics",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueBasicsNotFound",
            "description": "<p>The <code>id</code> of the League basics was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueBasicsNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league basic information was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/competition/:competitionId/weeks",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Competition_Weeks",
    "permission": [
      {
        "name": "organization, JWT"
      }
    ],
    "description": "<p>Creates a new League Competition week for the League Competition</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "competitionId",
            "description": "<p>Competition id of the competition.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "competition_type",
            "description": "<p>Type of the competition.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the competition week.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "start_date",
            "description": "<p>Start date of the competition week.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "end_date",
            "description": "<p>End date of the competition week.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueCompetitionWeeks</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n         'competition_id' => 3,\n         'competition_type' => 'Finals',\n         'name' => 'NBA',\n         'start_date' => '2016-05-10 06:58:46',\n         'end_date' => '2016-05-10 06:58:46'\n         ],\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueCompetitionWeeksController.php",
    "groupTitle": "League_Competition_Weeks"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/competition/:competitionId/weeks",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Competition_Weeks",
    "permission": [
      {
        "name": "organization, JWT"
      }
    ],
    "description": "<p>Returns the basic information for the requested competition of the requested league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "competitionId",
            "description": "<p>Competition id of the competition.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueCompetitionWeeks</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'id' => 1,\n             'competition_id' => 3,\n             'competition_type' => 'Finals',\n             'name' => 'NBA',\n             'start_date' => '2016-05-10 06:58:46',\n             'end_date' => '2016-05-10 06:58:46'\n         },\n         {\n             'id' => 2,\n             'competition_id' => 4,\n             'competition_type' => 'Semi-Finals',\n             'name' => 'NBA',\n             'start_date' => '2016-05-10 06:58:46',\n             'end_date' => '2016-05-10 06:58:46'\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueCompetitionWeeksController.php",
    "groupTitle": "League_Competition_Weeks"
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/details",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Details",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new League Details for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>League id of the league to save the basics to</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "\"Existing game structure ID\""
            ],
            "optional": false,
            "field": "game_structure_id",
            "description": "<p>Game Structure of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "\"Existing playoff structure ID\""
            ],
            "optional": false,
            "field": "playoff_structure_id",
            "description": "<p>Playoff Structure of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "\"Existing season structure ID\""
            ],
            "optional": false,
            "field": "season_structure_id",
            "description": "<p>Season Structure of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "number_of_teams",
            "description": "<p>Number of teams</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "players_per_team",
            "description": "<p>Number of player per team</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "max_players",
            "description": "<p>Maximum number of players for a league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "game_duration",
            "description": "<p>The duration of the game in minutes</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "time_period",
            "description": "<p>The time of each period of the match in minutes</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationDetails</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'league_id' => '6',\n         'game_structure_id' => '5',\n         'playoff_structure_id' => '3',\n         'season_structure_id' => '4',\n         'number_of_teams' => '25',\n         'players_per_team' => '11',\n         'max_players' => '25',\n         'game_duration' => '90',\n         'time_period' => '45',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationDetailsController.php",
    "groupTitle": "League_Details",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/details",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Details",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets the league details</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "LeagueId",
            "description": "<p>Id of the League</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'league_id' => '6',\n             'game_structure_id' => '5',\n             'playoff_structure_id' => '3',\n             'season_structure_id' => '4',\n             'number_of_teams' => '25',\n             'players_per_team' => '11',\n             'max_players' => '25',\n             'game_duration' => '90',\n             'time_period' => '45',\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationDetailsController.php",
    "groupTitle": "League_Details",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/leagues/:leagueId/league_details",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "League_Details",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the league details</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "\"Existing game structure ID\""
            ],
            "optional": false,
            "field": "game_structure_id",
            "description": "<p>Game Structure of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "\"Existing playoff structure ID\""
            ],
            "optional": false,
            "field": "playoff_structure_id",
            "description": "<p>Playoff Structure of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "allowedValues": [
              "\"Existing season structure ID\""
            ],
            "optional": false,
            "field": "season_structure_id",
            "description": "<p>Season Structure of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "number_of_teams",
            "description": "<p>Number of teams</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "players_per_team",
            "description": "<p>Number of player per team</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "max_players",
            "description": "<p>Maximum number of players for a league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "game_duration",
            "description": "<p>The duration of the game in minutes</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "time_period",
            "description": "<p>The time of each period of the match in minutes</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'league_id' => '6',\n         'game_structure_id' => '5',\n         'playoff_structure_id' => '3',\n         'season_structure_id' => '4',\n         'number_of_teams' => '25',\n         'players_per_team' => '11',\n         'max_players' => '25',\n         'game_duration' => '90',\n         'time_period' => '45',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationDetailsController.php",
    "groupTitle": "League_Details",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/divisions",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Division",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new League Division for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league to save the division</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the division</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueDivision</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n         'name' => 'First Division',\n         'league_id' => 1,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationDivisionsController.php",
    "groupTitle": "League_Division",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "DivisionNotFound",
            "description": "<p>The <code>id</code> of the division was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-DivisionNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The division was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/divisions/:divisionId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Division",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the league division</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>league id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "divisionId",
            "description": "<p>league division id to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Successfully Deleted'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationDivisionsController.php",
    "groupTitle": "League_Division",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "DivisionNotFound",
            "description": "<p>The <code>id</code> of the division was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-DivisionNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The division was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/divisions",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "group": "League_Division",
    "description": "<p>Returns the League Divisions for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueDivision</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'id' => 1,\n             'name' => 'First Division',\n             'league_id' => 1,\n         },\n         {\n             'id' => 2,\n             'name' => 'Second Division',\n             'league_id' => 1,\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationDivisionsController.php",
    "groupTitle": "League_Division",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "DivisionNotFound",
            "description": "<p>The <code>id</code> of the division was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-DivisionNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The division was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/divisions/:divisionId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Division",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets a the league division</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "LeagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "divisionId",
            "description": "<p>Division Id of the division</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n         'name' => 'First Division',\n         'league_id' => 1,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationDivisionsController.php",
    "groupTitle": "League_Division",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "DivisionNotFound",
            "description": "<p>The <code>id</code> of the division was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-DivisionNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The division was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/features",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Feature",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Creates a new League Feature for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league to save the feature</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the feature</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "icon",
            "description": "<p>Icon of the feature</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueFeature</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n         'league_id' => 1,\n         'league_feature_id' => 1,\n         'name' => 'Referees',\n         'icon' => 'test/icon/name.png',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationFeaturesController.php",
    "groupTitle": "League_Feature",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/features/:feature",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Feature",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Deletes the league feature</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>league id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "feature",
            "description": "<p>feature id to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => 'true'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationFeaturesController.php",
    "groupTitle": "League_Feature",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/features",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "group": "League_Feature",
    "description": "<p>Returns the League Features for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueFeature</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'id' => 1,\n             'league_id' => 1,\n             'league_feature_id' => 1,\n             'name' => 'Referees',\n             'icon' => 'test/icon/name.png'\n         },\n         {\n             'id' => 2,\n             'league_id' => 2,\n             'league_feature_id' => 2,\n             'name' => 'Referees',\n             'icon' => 'test/icon/name.png'\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationFeaturesController.php",
    "groupTitle": "League_Feature",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/games",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Game",
    "description": "<p>Returns an array of information belonging to a league game</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array with information about a league game.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => 1,\n             'location' => $game_location,\n             'datetime' => $game_datetime,\n             'date' => $game_date,\n             'competition_id' => $game_competition_id,\n             'competition_type' => $game_competition_type,\n             'league_id' => $game_league_id,\n             'home_team' => $game_home_team,\n             'visiting_team' => $game_visiting_team,\n             'home_team_id' => $game_home_team_id,\n             'visiting_team_id' => $game_visiting_team_id,\n             'home_team_score' => $game_home_team_score,\n             'visiting_team_score' => $game_visiting_team_score,\n             'home_team_logo' => $game_home_team_logo,\n             'home_team_logi_id' => $game_home_team_logo_id,\n             'visiting_team_logo' => $game_visiting_team_logo,\n             'visiting_team_logo_id' => $game_visiting_team_logo_id,\n             'week' => $game_week\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "home_team_id",
            "description": "<p>The id of the home team</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "visiting_team_id",
            "description": "<p>The id of the visiting team</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "location_id",
            "description": "<p>The id of the location where the game will be played</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "game_structure_id",
            "description": "<p>The id of the game structure for the game</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "sport_id",
            "description": "<p>The id of the sport of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "home_team_score",
            "description": "<p>The score of the home team</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "visiting_team_score",
            "description": "<p>The score of the visiting team</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "competition_id",
            "description": "<p>The id of the competition that the game belongs to</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "competition_type",
            "description": "<p>The type of the competition that the game belongs to</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "stats_id",
            "description": "<p>The id of the stats of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "stats_type",
            "description": "<p>The type of the stats of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "week_id",
            "description": "<p>The id of the week that the game belongs to</p>"
          },
          {
            "group": "Parameter",
            "type": "timestamp",
            "optional": true,
            "field": "time",
            "description": "<p>The time of the game</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGamesController.php",
    "groupTitle": "League_Game"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/games/:gameId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Game",
    "description": "<p>Returns an array of information belonging to a league game</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array with information about a league game.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": true\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "leagueId",
            "description": "<p>The id of the league of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "gameId",
            "description": "<p>The id of the game</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGamesController.php",
    "groupTitle": "League_Game"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/games/:gameId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Game",
    "description": "<p>Returns an array of information belonging to a league game</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array with information about a league game.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => 1,\n             'location' => $game_location,\n             'datetime' => $game_datetime,\n             'date' => $game_date,\n             'competition_id' => $game_competition_id,\n             'competition_type' => $game_competition_type,\n             'league_id' => $game_league_id,\n             'home_team' => $game_home_team,\n             'visiting_team' => $game_visiting_team,\n             'home_team_id' => $game_home_team_id,\n             'visiting_team_id' => $game_visiting_team_id,\n             'home_team_score' => $game_home_team_score,\n             'visiting_team_score' => $game_visiting_team_score,\n             'home_team_logo' => $game_home_team_logo,\n             'home_team_logi_id' => $game_home_team_logo_id,\n             'visiting_team_logo' => $game_visiting_team_logo,\n             'visiting_team_logo_id' => $game_visiting_team_logo_id,\n             'week' => $game_week\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "leagueId",
            "description": "<p>The id of the league of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "gameId",
            "description": "<p>The id of the game</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGamesController.php",
    "groupTitle": "League_Game"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/games/:gameId",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "League_Game",
    "description": "<p>Returns an array of information belonging to a league game</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array with information about a league game.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => 1,\n             'location' => $game_location,\n             'datetime' => $game_datetime,\n             'date' => $game_date,\n             'competition_id' => $game_competition_id,\n             'competition_type' => $game_competition_type,\n             'league_id' => $game_league_id,\n             'home_team' => $game_home_team,\n             'visiting_team' => $game_visiting_team,\n             'home_team_id' => $game_home_team_id,\n             'visiting_team_id' => $game_visiting_team_id,\n             'home_team_score' => $game_home_team_score,\n             'visiting_team_score' => $game_visiting_team_score,\n             'home_team_logo' => $game_home_team_logo,\n             'home_team_logi_id' => $game_home_team_logo_id,\n             'visiting_team_logo' => $game_visiting_team_logo,\n             'visiting_team_logo_id' => $game_visiting_team_logo_id,\n             'week' => $game_week\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "home_team_id",
            "description": "<p>The id of the home team</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "visiting_team_id",
            "description": "<p>The id of the visiting team</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "location_id",
            "description": "<p>The id of the location where the game will be played</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "game_structure_id",
            "description": "<p>The id of the game structure for the game</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "sport_id",
            "description": "<p>The id of the sport of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "home_team_score",
            "description": "<p>The score of the home team</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "visiting_team_score",
            "description": "<p>The score of the visiting team</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "competition_id",
            "description": "<p>The id of the competition that the game belongs to</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "competition_type",
            "description": "<p>The type of the competition that the game belongs to</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "stats_id",
            "description": "<p>The id of the stats of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "stats_type",
            "description": "<p>The type of the stats of the game</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "week_id",
            "description": "<p>The id of the week that the game belongs to</p>"
          },
          {
            "group": "Parameter",
            "type": "timestamp",
            "optional": true,
            "field": "time",
            "description": "<p>The time of the game</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGamesController.php",
    "groupTitle": "League_Game"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/games/:gameId/photos/:offset/:limit",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Game_Photos",
    "description": "<p>Returns the photos for the games of the requested league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "gameId",
            "description": "<p>Game id of the sport.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "offset",
            "description": "<p>Pagination</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "limit",
            "description": "<p>Limit of the photos.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationGamePhoto</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'league_id' => 1,\n             'image_id' => '3',\n             'album_id' => '3',\n             'game_id' => '2',\n             'file_name' => 'Darian Ryan DDS',\n             'file_path' => '/public/images/testphoto.jpeg',\n             'thumbnail_path' => '/public/images/testphoto_thumbnail.jpeg',\n             'size' => '85002',\n             'mime_type' => 'application/yang',\n             'extension' => 'wmd',\n             'role' => 4,\n             'description' => 'In a quis sit vel amet enim pariatur. Quia et voluptas qui. Provident modi minus deleniti aperiam ex. Nam omnis itaque assumenda architecto dolores quam.',\n             'created_at' => '2016-05-10 06:58:46',\n             'updated_at' => '2016-05-10 06:58:46'\n         },\n         {\n             'league_id' => 1,\n             'image_id' => 3,\n             'album_id' => 3,\n             'game_id' => 2,\n             'file_name' => 'Darian Ryan DDS',\n             'file_path' => '/public/images/testphoto.jpeg',\n             'thumbnail_path' => '/public/images/testphoto_thumbnail.jpeg',\n             'size' => '85002',\n             'mime_type' => 'application/yang',\n             'extension' => 'wmd',\n             'role' => 4,\n             'description' => 'In a quis sit vel amet enim pariatur. Quia et voluptas qui. Provident modi minus deleniti aperiam ex. Nam omnis itaque assumenda architecto dolores quam.',\n             'created_at' => '2016-05-10 06:58:46',\n             'updated_at' => '2016-05-10 06:58:46'\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGamePhotosController.php",
    "groupTitle": "League_Game_Photos"
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/games/:gameId/player-stats",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Game_Stats",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Creates a new Game Stat for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "gameId",
            "description": "<p>Game id of the game.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "method",
            "description": "<p>Type of submission(form,upload)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport",
            "description": "<p>Sport for which stat is to store.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueFeature</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n         'player_id' => 53,\n         'team_id' => 5,\n         'jersey' => '0  Jordan',\n         'PTS' => '35',\n         '3FG' => '0',\n         '3FGA' => '0',\n         'AST' => '0',\n         'BLK' => '0',\n         'FG' => '0',\n         'FG_percent' => '0',\n         'FGA' => '0',\n         'FL' => '0',\n         'FT' => '0',\n         'FTA' => '0',\n         'RBO' => '0',\n         'RBT' => '0',\n         'STL' => '0',\n         'TURN' => '0',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGameStatsController.php",
    "groupTitle": "League_Game_Stats"
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/games/:gameId/player-stats",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Game_Stats",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Deletes the league game stat</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "gameId",
            "description": "<p>Game id of the game.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "team_id",
            "description": "<p>team id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport",
            "description": "<p>sport stat to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'true'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGameStatsController.php",
    "groupTitle": "League_Game_Stats"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/games/:gameId/player-stats",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "group": "League_Game_Stats",
    "description": "<p>Returns the Game Stats for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "gameId",
            "description": "<p>Game id of the game.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueGameStats</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'id' => 1,\n             'player_id' => 53,\n             'team_id' => 5,\n             'jersey' => '0  Jordan',\n             'PTS' => '35',\n             '3FG' => '0',\n             '3FGA' => '0',\n             'AST' => '0',\n             'BLK' => '0',\n             'FG' => '0',\n             'FG_percent' => '0',\n             'FGA' => '0',\n             'FL' => '0',\n             'FT' => '0',\n             'FTA' => '0',\n             'RBO' => '0',\n             'RBT' => '0',\n             'STL' => '0',\n             'TURN' => '0'\n         },\n         {\n             'id' => 2,\n             'player_id' => 53,\n             'team_id' => 5,\n             'jersey' => '0  Jordan',\n             'PTS' => '35',\n             '3FG' => '0',\n             '3FGA' => '0',\n             'AST' => '0',\n             'BLK' => '0',\n             'FG' => '0',\n             'FG_percent' => '0',\n             'FGA' => '0',\n             'FL' => '0',\n             'FT' => '0',\n             'FTA' => '0',\n             'RBO' => '0',\n             'RBT' => '0',\n             'STL' => '0',\n             'TURN' => '0'\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGameStatsController.php",
    "groupTitle": "League_Game_Stats"
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/game-venues",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Game_Venue",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new League Game Venue for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>League id of the league to save the game venue</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "full_address",
            "description": "<p>Address of the venue</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "country_id",
            "description": "<p>Country where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "city_name",
            "description": "<p>City where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>State where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flat",
            "description": "<p>Flat where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "x",
            "description": "<p>Coordinate x where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "y",
            "description": "<p>Coordinate y where the venue is</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationDetails</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 6,\n         'league_id' => 6,\n         'location_id' => 6,\n         'full_address' => '5 Avenue 14',\n         'country' => 'United States',\n         'country_id' => 4,\n         'city' => 'New York City',\n         'city_id' => 10,\n         'state' => 'New York',\n         'latitude' => '42.5342',\n         'longitude' => '112.3235',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGameVenuesController.php",
    "groupTitle": "League_Game_Venue",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/game-venues/:gameVenueId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Game_Venue",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the league game venue</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "LeagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "gameVenueId",
            "description": "<p>Id of the Game Venue</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGameVenuesController.php",
    "groupTitle": "League_Game_Venue",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueDetailsNotFound",
            "description": "<p>The league game venue was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "GameVenueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league game venue was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/game-venues",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Game_Venue",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Returns all games venues for a league</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Collection",
            "optional": false,
            "field": "array",
            "description": "<p>Collection with all the game venues of the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  [\n         'address' => '5 Avenue 14',\n         'country' => 'United States',\n         'city' => 'New York City',\n         'state' => 'New York',\n         'x' => '42.5342',\n         'y' => '112.3235',\n  ],\n  [\n         'address' => '5 Avenue 14',\n         'country' => 'United States',\n         'city' => 'New York City',\n         'state' => 'New York',\n         'x' => '42.5342',\n         'y' => '112.3235',\n  ],\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGameVenuesController.php",
    "groupTitle": "League_Game_Venue",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueDetailsNotFound",
            "description": "<p>The league game venue was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "GameVenueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league game venue was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/game-venues/:gameVenueId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Game_Venue",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets a the league game venue</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "LeagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "gameVenueId",
            "description": "<p>Id of the Game Venue</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 6,\n         'league_id' => 6,\n         'full_address' => '5 Avenue 14',\n         'country' => 'United States',\n         'country_id' => 4,\n         'city' => 'New York City',\n         'city_id' => 10,\n         'state' => 'New York',\n         'latitude' => '42.5342',\n         'longitude' => '112.3235',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGameVenuesController.php",
    "groupTitle": "League_Game_Venue",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueDetailsNotFound",
            "description": "<p>The league game venue was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "GameVenueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league game venue was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/leagues/:leagueId/game-venues/:gameVenueId",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "League_Game_Venue",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the league game venue</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league to update the game venue</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "gameVenueId",
            "description": "<p>Id of the Game Venue</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>Address of the venue</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "country_id",
            "description": "<p>Country where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>City where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>State where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "x",
            "description": "<p>Coordinate x where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "y",
            "description": "<p>Coordinate y where the venue is</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 6,\n         'league_id' => 6,\n         'location_id' => 6,\n         'full_address' => '5 Avenue 14',\n         'country' => 'United States',\n         'country_id' => 4,\n         'city' => 'New York City',\n         'city_id' => 10,\n         'state' => 'New York',\n         'latitude' => '42.5342',\n         'longitude' => '112.3235',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGameVenuesController.php",
    "groupTitle": "League_Game_Venue",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueDetailsNotFound",
            "description": "<p>The league game venue was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "GameVenueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league game venue was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/games/:gameId/videos/:offset/:limit",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Game_Videos",
    "description": "<p>Returns the videos for the games of the requested league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "gameId",
            "description": "<p>Game id of the sport.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "offset",
            "description": "<p>Pagination</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "limit",
            "description": "<p>Limit of the photos.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueGameVideo</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'league_id' => 1,\n             'video_id' => 1,\n             'label_id' => 3,\n             'game_id' => 2,\n             'file_name' => 'Jodie Gleason',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $video->thumbnail_path,\n             'size' => '81686',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n             'description' => 'Praesentium sed perspiciatis aut aut. Ullam omnis aliquam qui modi autem. Provident adipisci dolores itaque praesentium aspernatur dolorem. Explicabo nihil suscipit illo placeat dolorem ea.',\n             'created_at' => '2016-05-10 06:58:47',\n             'updated_at' => '2016-05-10 06:58:47'\n         },\n         {\n             'league_id' => 2,\n             'video_id' => 2,\n             'label_id' => 3,\n             'game_id' => 3,\n             'file_name' => 'Jodie Gleason',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $video->thumbnail_path,\n             'size' => '81686',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n             'description' => 'Praesentium sed perspiciatis aut aut. Ullam omnis aliquam qui modi autem. Provident adipisci dolores itaque praesentium aspernatur dolorem. Explicabo nihil suscipit illo placeat dolorem ea.',\n             'created_at' => '2016-05-10 06:58:47',\n             'updated_at' => '2016-05-10 06:58:47'\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGameVideosController.php",
    "groupTitle": "League_Game_Videos"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/games",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Games",
    "description": "<p>Returns an array of all the league games that match the filter parameters</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array with all the league games.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => $game_id,\n                    'game_venue' => $game_venue,\n                    'location' => $game_location,\n                    'datetime' => $game_time,\n                    'date' => $game_date,\n                    'stage_id' => $game_stage_id,\n                    'stage_type' => $game_stage_type,\n                    'competition_id' => $game_competition_id,\n                    'competition_type' => $game_competition_type,\n                    'organization_id' => $game_organization_id,\n                    'organization_type' => $game_organization_type,\n                    'sport' => $game_sport,\n                    'home_team' => $game_home_team,\n                    'visiting_team' => $game_visiting_team,\n                    'home_team_id' => $game_home_team_id,\n                    'visiting_team_id' => $game_visiting_team_id,\n                    'home_team_score' => $game_home_team_score,\n                    'visiting_team_score' => $game_visiting_team_score,\n                    'home_team_win' => $game_home_team_win,\n                    'visiting_team_win' => $game_visiting_team_win,\n                    'home_team_loss' => $game_home_team_loss,\n                    'visiting_team_loss' => $game_visiting_team_loss,\n                    'home_team_draw' => $game_home_team_draw,\n                    'visiting_team_draw' => $game_visiting_team_draw,\n                    'home_team_logo' => $game_home_team_logo,\n                    'home_team_logo_id' => $game_home_team_logo_id,\n                    'visiting_team_logo' => $game_visiting_team_logo,\n                    'visiting_team_logo_id' => $game_visiting_team_logo_id,\n                    'week' => $game_week,\n                    'time' => $game_time,\n                    'day' => $game_time_day,\n                    'month' => $game_time_month,\n                    'year' => $game_time_year,\n                    'hour' => $game_time_hour,\n                    'minute' => $game_time_minute,\n                    'second' => $game_time_second,\n                    'created_at' => $game_created_at,\n                    'updated_at' => $game_updated_at,\n                    'scored' => $game_scored,\n                    'game_status' => $game_status\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "offset",
            "description": "<p>Indicates how much to offset the games when retrieving the games from the database</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "limit",
            "description": "<p>The max nimber of games that will be queried</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "orderBy",
            "description": "<p>The parameter to order the games by</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "orderDirection",
            "description": "<p>The order direction of the games</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "teamId",
            "description": "<p>The id of the team that should belong to all games returned</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "playerId",
            "description": "<p>The id of the player that should belong to all games returned</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "seasonId",
            "description": "<p>The id of the season that all games returned should belong to</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "divisionId",
            "description": "<p>The id of the division that all games returned should belong to</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "weekId",
            "description": "<p>The id of the week that the games should belong to</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "all",
            "description": "<p>Notifies the api whether or not to return all games without a limit</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "competitionId",
            "description": "<p>The id of the week that the games will belong to</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "competitionType",
            "description": "<p>The id of the competition that all games returned should belong to</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "pick",
            "description": "<p>The index of the game that should be returned</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "game_status",
            "description": "<p>The status of the games that should be returned</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "scored",
            "description": "<p>Notifies the api whether or not to return scored games</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationGamesController.php",
    "groupTitle": "League_Games"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/info",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Information",
    "permission": [
      {
        "name": "public"
      }
    ],
    "description": "<p>Get the league and organization basic informations</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "LeagueId",
            "description": "<p>Id of the League</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     {\n         \"data\": {\n         \"id\": 1,\n             \"name\": \" ... \",\n             \"description\": \" ... \",\n             \"organization\": {\n                 \"id\": 1,\n                 \"name\": \" ... \",\n                 \"email\": \" ... \",\n                 \"phone\": \" ... \",\n                 \"image\": \" ... \",\n                 \"social\": {\n                     \"facebook\": \" ... \",\n                     \"twitter\": \" ... \",\n                     \"instagram\": \" ... \",\n                     \"pinterest\": \" ... \",\n                     \"google\": \" ... \"\n                 }\n             }\n         }\n     }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationInfoController.php",
    "groupTitle": "League_Information",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/locations",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Location",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new League Game Venue for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>League id of the league to save the location</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "full_address",
            "description": "<p>Address of the venue</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "country_id",
            "description": "<p>Country where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "city_id",
            "description": "<p>City where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>State where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flat",
            "description": "<p>Flat where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "x",
            "description": "<p>Coordinate x where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "y",
            "description": "<p>Coordinate y where the venue is</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationLocation</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 6,\n         'league_id' => 6,\n         'location_id' => 6,\n         'full_address' => '5 Avenue 14',\n         'country' => 'United States',\n         'country_id' => 4,\n         'city' => 'New York City',\n         'city_id' => 10,\n         'state' => 'New York',\n         'latitude' => '42.5342',\n         'longitude' => '112.3235',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationLocationsController.php",
    "groupTitle": "League_Location",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/locations/:leagueLocationId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Location",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the league location</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueLocationId",
            "description": "<p>Id of the league location to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationLocationsController.php",
    "groupTitle": "League_Location",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueLocationNotFound",
            "description": "<p>The <code>id</code> of the League location was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueLocationNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league location does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/locations",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "group": "League_Location",
    "description": "<p>Returns the League Game Venue for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationLocation</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'league_location_id' => 1,\n             'league_id' => 1,\n             'location_id' => 1,\n             'country' => 'Micheal Wilkinson',\n             'city' => 'North Catherine',\n             'state' => 'NY',\n             'longitude' => '136.271624',\n             'latitude' => '51.191592',\n             'name' => 'Miss Bonnie Champlin',\n             'street' => '42.5342',\n             'zip' => '56273',\n             'full_address' => '906 Horace Rest Suite 067 Schillershire, MO 09302',\n             'flat' => '128',\n             'distance' => '112.3235'\n         },\n         {\n             'league_location_id' => 2,\n             'league_id' => 2,\n             'location_id' => 1,\n             'country' => 'Micheal Wilkinson',\n             'city' => 'North Catherine',\n             'state' => 'NY',\n             'longitude' => '136.271624',\n             'latitude' => '51.191592',\n             'name' => 'Miss Bonnie Champlin',\n             'street' => '42.5342',\n             'zip' => '56273',\n             'full_address' => '906 Horace Rest Suite 067 Schillershire, MO 09302',\n             'flat' => '128',\n             'distance' => '112.3235'\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationLocationsController.php",
    "groupTitle": "League_Location",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/locations/:leagueLocationId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Location",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets a the league location</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueLocationId",
            "description": "<p>Location Id of the League</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 6,\n         'league_id' => 6,\n         'full_address' => '5 Avenue 14',\n         'country' => 'United States',\n         'country_id' => 4,\n         'city' => 'New York City',\n         'city_id' => 10,\n         'state' => 'New York',\n         'latitude' => '42.5342',\n         'longitude' => '112.3235',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationLocationsController.php",
    "groupTitle": "League_Location",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueLocationNotFound",
            "description": "<p>The <code>id</code> of the League location was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueLocationNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league location does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/leagues/:leagueId/locations/:leagueLocationId",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "League_Location",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the league location</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueLocationId",
            "description": "<p>Location id of the league to save the location</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>Address of the venue</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "country_id",
            "description": "<p>Country where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>City where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>State where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "x",
            "description": "<p>Coordinate x where the venue is</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "y",
            "description": "<p>Coordinate y where the venue is</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 6,\n         'league_id' => 6,\n         'location_id' => 6,\n         'full_address' => '5 Avenue 14',\n         'country' => 'United States',\n         'country_id' => 4,\n         'city' => 'New York City',\n         'city_id' => 10,\n         'state' => 'New York',\n         'latitude' => '42.5342',\n         'longitude' => '112.3235',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationLocationsController.php",
    "groupTitle": "League_Location",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueLocationNotFound",
            "description": "<p>The <code>id</code> of the League location was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueLocationNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league location does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/league/:leagueId/create-passcode",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Passcodes",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Creates a new Passcode for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>League id of the league to create the passcode to</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "passcode",
            "description": "<p>Passcode for the league.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationBasics</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n         'league_id' => '6',\n         'sport_id' => '4',\n         'min_age' => '14',\n         'max_age' => '18',\n         'gender' => 'female',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPasscodesController.php",
    "groupTitle": "League_Passcodes",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeaguePasscodeLength",
            "description": "<p>Passcode should not be less or greater than 6 characters!.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeaguePasscodeAlreadyCreated",
            "description": "<p>Passcode for the league is already created.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeaguePasscodeLength",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"Passcode should not be less or greater than 6 characters! \"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeaguePasscodeAlreadyCreated",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"Passcode for the league is already created \"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/photos",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Photo",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new Photo for a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>League id</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "image",
            "description": "<p>Image The photo to attach to the league</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Description of the photo</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeaguePhoto</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 6,\n         'league_id' => 6,\n         'image' => 'football_match_beach.jpg',\n         'description' => 'Football match in the beach',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPhotosController.php",
    "groupTitle": "League_Photo",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/photos/:leaguePhotoId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Photo",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the league photo</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leaguePhotoId",
            "description": "<p>Id of the league photo to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPhotosController.php",
    "groupTitle": "League_Photo",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeaguePhotoNotFound",
            "description": "<p>The league photo was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeaguePhotoNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league photo was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/photos/:leaguePhotoId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Photo",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets a league photo</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "LeagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leaguePhotoId",
            "description": "<p>Id of the League Photo</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 6,\n         'league_id' => 6,\n         'image' => 'football_match_beach.jpg',\n         'description' => 'Football match in the beach',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPhotosController.php",
    "groupTitle": "League_Photo",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeaguePhotoNotFound",
            "description": "<p>The league photo was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeaguePhotoNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league photo was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/leagues/:leagueId/photos/:photoId",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "League_Photo",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates a new Photo for a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>League id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "photo_id",
            "description": "<p>Image The photo to attach to the league</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeaguePhoto</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 6,\n         'league_id' => 6,\n         'image' => 'football_match_beach.jpg',\n         'description' => 'Football match in the beach',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPhotosController.php",
    "groupTitle": "League_Photo",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/photoAlbum",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Photo_Albums",
    "permission": [
      {
        "name": "organization, JWT"
      }
    ],
    "description": "<p>Creates a new Photo Album for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "album_name",
            "description": "<p>Name of the photo album.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationPhotoAlbums</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Album created successfully!'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPhotoAlbumsController.php",
    "groupTitle": "League_Photo_Albums",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/photoAlbum/:album_id",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Photo_Albums",
    "permission": [
      {
        "name": "organization, JWT"
      }
    ],
    "description": "<p>Delete Photo Album for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "album_id",
            "description": "<p>Album id of the album.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "album_name",
            "description": "<p>Name of the photo album.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationPhotoAlbums</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Album deleted successfully!'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPhotoAlbumsController.php",
    "groupTitle": "League_Photo_Albums",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/photoAlbum",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Photo_Albums",
    "permission": [
      {
        "name": "organization, JWT"
      }
    ],
    "description": "<p>Returns the photo albums of the requested league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>League id of the league.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationPhotoAlbums</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'id' => 1,\n             'name' => 'Finals',\n         },\n         {\n             'id' => 2,\n             'name' => 'Semi-Finals',\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPhotoAlbumsController.php",
    "groupTitle": "League_Photo_Albums",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/photoAlbum/:album_id",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "League_Photo_Albums",
    "permission": [
      {
        "name": "organization, JWT"
      }
    ],
    "description": "<p>Update Photo Album for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "album_id",
            "description": "<p>Album id of the album.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "album_name",
            "description": "<p>Name of the photo album.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationPhotoAlbums</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Album update successfully!'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPhotoAlbumsController.php",
    "groupTitle": "League_Photo_Albums",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/photos",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Photos",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Returns all photos for a league</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Collection",
            "optional": false,
            "field": "array",
            "description": "<p>Collection with all the photos.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  [\n         'id' => 6,\n         'league_id' => 2,\n         'source' => 'football_match_beach.jpg',\n         'name' => 'Football match in the beach',\n  ],\n  [\n         'id' => 8,\n         'league_id' => 2,\n         'source' => 'football_match_court.jpg',\n         'name' => 'Football match in the court',\n  ],\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPhotosController.php",
    "groupTitle": "League_Photos",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeaguePhotoNotFound",
            "description": "<p>The league photo was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeaguePhotoNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league photo was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/players/:playerId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Player",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Deletes a player from a league. It will also delete the player from the teams where he was playing on that league.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>ID of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "playerId",
            "description": "<p>ID of the player to be deleted</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Successfully Deleted'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPlayersController.php",
    "groupTitle": "League_Player",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/players",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Player",
    "description": "<p>Returns an array of all the player on the league that matches the filter parameters</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "order_by",
            "description": "<p>Order by</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "order_direction",
            "description": "<p>Direction of order</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "offset",
            "description": "<p>Offset</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "limit",
            "description": "<p>Limit</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => $player->id,\n         'email' => $player->email,\n         'first_name' => $player->first_name,\n         'last_name' => $player->last_name,\n         'phone' => $player->phone,\n         'birthday' => $player->birthday,\n         'gender' => $player->gender,\n         'picture' => $player->picture,\n         'school' => $player->school,\n         'position' => $player->position,\n         'city' => $player->city,\n         'state' => $player->state,\n         'name' => $player->first_name . ' ' . $player->last_name,\n         'teams' => CollectionOfTeams\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPlayersController.php",
    "groupTitle": "League_Player",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/players",
    "title": "Create",
    "version": "1.0.0",
    "name": "Invite_player",
    "group": "League_Player",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Invites and creates (if not exists) a player to join the league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email, must be unique</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "first_name",
            "description": "<p>First name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "last_name",
            "description": "<p>Last name of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>Phone of the player</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => $player->id,\n         'email' => $player->email,\n         'first_name' => $player->first_name,\n         'last_name' => $player->last_name,\n         'phone' => $player->phone,\n         'birthday' => $player->birthday,\n         'gender' => $player->gender,\n         'picture' => $player->picture,\n         'school' => $player->school,\n         'position' => $player->position,\n         'city' => $player->city,\n         'state' => $player->state,\n         'name' => $player->first_name . ' ' . $player->last_name,\n         'teams' => CollectionOfTeams\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPlayersController.php",
    "groupTitle": "League_Player",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/player/:playerId/photos/:offset/limit",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Player_Photos",
    "description": "<p>Returns the photos for the players of the requested league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "playerId",
            "description": "<p>Player id of the sport.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "offset",
            "description": "<p>Pagination</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "limit",
            "description": "<p>Limit of the photos.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationPlayerPhoto</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'league_id' => 1,\n             'image_id' => 3,\n             'album_id' => 3,\n             'game_id' => 2,\n             'file_name' => 'Darian Ryan DDS',\n             'file_path' => '/public/images/testphoto.jpeg',\n             'thumbnail_path' => '/public/images/testphoto_thumbnail.jpeg',\n             'size' => '85002',\n             'mime_type' => 'application/yang',\n             'extension' => 'wmd',\n             'role' => 4,\n             'description' => 'In a quis sit vel amet enim pariatur. Quia et voluptas qui. Provident modi minus deleniti aperiam ex. Nam omnis itaque assumenda architecto dolores quam.',\n         },\n         {\n             'league_id' => 1,\n             'image_id' => 4,\n             'album_id' => 4,\n             'game_id' => 2,\n             'file_name' => 'Darian Ryan DDS',\n             'file_path' => '/public/images/testphoto.jpeg',\n             'thumbnail_path' => '/public/images/testphoto_thumbnail.jpeg',\n             'size' => '85002',\n             'mime_type' => 'application/yang',\n             'extension' => 'wmd',\n             'role' => 4,\n             'description' => 'In a quis sit vel amet enim pariatur. Quia et voluptas qui. Provident modi minus deleniti aperiam ex. Nam omnis itaque assumenda architecto dolores quam.',\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPlayerPhotosController.php",
    "groupTitle": "League_Player_Photos"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/team/:teamId/videos/:offset/:limit",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Player_Videos",
    "description": "<p>Returns the videos for the team of the requested league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "teamId",
            "description": "<p>Team id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "offset",
            "description": "<p>Pagination</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "limit",
            "description": "<p>Limit of the photos.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationTeamVideo</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'league_id' => 1,\n             'video_id' => 1,\n             'label_id' => 3,\n             'game_id' => 2,\n             'file_name' => 'Jodie Gleason',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $leagueTeamVideo->thumbnail_path,\n             'size' => '81686',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n         },\n         {\n             'league_id' => 2,\n             'video_id' => 2,\n             'label_id' => 3,\n             'game_id' => 3,\n             'file_name' => 'Jodie Gleason',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $leagueTeamVideo->thumbnail_path,\n             'size' => '81686',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationTeamVideosController.php",
    "groupTitle": "League_Player_Videos"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/player/:playerId/videos/:offset/:limit",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Player_Videos",
    "description": "<p>Returns the videos for the games of the requested league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "playerId",
            "description": "<p>Player id of the sport.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "offset",
            "description": "<p>Pagination</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "limit",
            "description": "<p>Limit of the photos.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationPlayerVideo</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'league_id' => 1,\n             'video_id' => 1,\n             'label_id' => 3,\n             'game_id' => 2,\n             'file_name' => 'Jodie Gleason',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $video->thumbnail_path,\n             'size' => '81686',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n         },\n         {\n             'league_id' => 2,\n             'video_id' => 2,\n             'label_id' => 3,\n             'game_id' => 3,\n             'file_name' => 'Jodie Gleason',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $video->thumbnail_path,\n             'size' => '81686',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPlayerVideosController.php",
    "groupTitle": "League_Player_Videos"
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/:token/:email/join-by-invitation",
    "title": "joinByInvitation",
    "version": "1.0.0",
    "name": "joinByInvitation",
    "group": "League_Player",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Invites a player from a league.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>ID of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email of the player to be invited</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'createLeagueSuccess' => 'You have been successfully added to the league'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPlayersController.php",
    "groupTitle": "League_Player",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerAlreadyJoinedLeague",
            "description": "<p>Player already joined the league.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerAlreadyJoinedTeamAsLeague",
            "description": "<p>Player has been already added to league with a team.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "PlayerAlreadyJoinedLeague:",
          "content": "HTTP/1.1 404 Not Allowed\n{\n  \"error\": {\n         \"message\": \"Player already joined the league\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "PlayerAlreadyJoinedTeamAsLeague:",
          "content": "HTTP/1.1 404 Not Allowed\n{\n  \"error\": {\n         \"message\": \"Player has been already added to league with a team\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/invite",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Private_Invites",
    "permission": [
      {
        "name": "organization, organization staff, requires JWT"
      }
    ],
    "description": "<p>Invites Player to join league.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>Id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email of the player to send invitation</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Player invited successfully',\n     'message' => 'Player invited successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPrivateInvitesController.php",
    "groupTitle": "League_Private_Invites",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeaguePhotoNotFound",
            "description": "<p>The league photo was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeaguePlayerAlreadyInvited",
            "description": "<p>This player is already invited.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeaguePhotoNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league photo was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeaguePlayerAlreadyInvited:",
          "content": "HTTP/1.1 404 Not Allowed\n{\n  \"error\": {\n         \"message\": \"This player is already invited\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/reviews",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Review",
    "description": "<p>Creates a new Review for the League</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league to save the review</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "review",
            "description": "<p>Review of the league</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationReview</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => 1,\n         'review' => 'Laudantium illo est quisquam eum illo autem. Totam optio quaerat enim qui sed. Quod est non quasi quis omnis consequatur provident.',\n         'reviewer_id' => 58,\n         'verified' => '1',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationReviewsController.php",
    "groupTitle": "League_Review",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/getAllReviews",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "group": "League_Review",
    "description": "<p>Returns the League Game Venue for the League</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationReview</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'id' => 1,\n             'review' => 'Laudantium illo est quisquam eum illo autem. Totam optio quaerat enim qui sed. Quod est non quasi quis omnis consequatur provident.',\n             'league_id' => 1,\n             'league_name' => 'Professional Spanish Football League',\n             'reviewer_id' => 1,\n             'reviewer_name' => 'Carlos',\n             'created_at' => '2016-05-10 06:58:57',\n             'updated_at' => '2016-05-10 06:58:57',\n         },\n         {\n         {\n             'id' => 2,\n             'review' => 'Laudantium illo est quisquam eum illo autem. Totam optio quaerat enim qui sed. Quod est non quasi quis omnis consequatur provident.',\n             'league_id' => 2,\n             'league_name' => 'Calcio',\n             'reviewer_id' => 2,\n             'reviewer_name' => 'Tupac',\n             'created_at' => '2016-05-10 06:58:57',\n             'updated_at' => '2016-05-10 06:58:57',\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationReviewsController.php",
    "groupTitle": "League_Review"
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/seasons",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Season",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new season for a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>League id of the league to create the season</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the price.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "starts_at",
            "description": "<p>The date when the season starts</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ends_at",
            "description": "<p>The date when the season ends</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "registration_opens_at",
            "description": "<p>The date when the season registration opens</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "registration_closes_at",
            "description": "<p>The date when the season registration closes</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "max_teams",
            "description": "<p>The maximum number of teams allowed in the season</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "max_free_agents",
            "description": "<p>The maximum number of free agents allowed in the season</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueSeason</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '2',\n         'league_id' => '6',\n         'name' => 'Summer Season',\n         'stars_at' => '15/10/2016',\n         'ends_at' => '15/12/2016',\n         'registration_opens_at' => '15/6/2016',\n         'registration_closes_at' => '15/10/2016',\n         'max_teams' => '10',\n         'max_free_agents' => '5',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationSeasonsController.php",
    "groupTitle": "League_Season",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/seasons/:leagueSeasonId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Season",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the league season</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>Id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueSeasonId",
            "description": "<p>Id of the league season to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationSeasonsController.php",
    "groupTitle": "League_Season",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "SeasonCompetitionNotFound",
            "description": "<p>The <code>id</code> of the League season was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SeasonCompetitionNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league season does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/seasons/:leagueSeasonId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Season",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets a league season</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "LeagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Id of the League Season</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '2',\n         'league_id' => '6',\n         'name' => 'Summer Season',\n         'stars_at' => '15/10/2016',\n         'ends_at' => '15/12/2016',\n         'registration_opens_at' => '15/6/2016',\n         'registration_closes_at' => '15/10/2016',\n         'max_teams' => '10',\n         'max_free_agents' => '5',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationSeasonsController.php",
    "groupTitle": "League_Season",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "SeasonCompetitionNotFound",
            "description": "<p>The <code>id</code> of the League season was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SeasonCompetitionNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league season does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/seasons/",
    "title": "Index",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Season",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets a league season</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "LeagueId",
            "description": "<p>Id of the League</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'id' => 2,\n             'league_id' => 6,\n             'name' => 'Summer Season',\n             'stars_at' => '15/10/2016',\n             'ends_at' => '15/12/2016',\n             'registration_opens_at' => '15/6/2016',\n             'registration_closes_at' => '15/10/2016',\n             'max_teams' => '10',\n             'max_free_agents' => '5'\n            },\n          {\n             'id' => 2,\n             'league_id' => 6,\n             'name' => 'Summer Season',\n             'stars_at' => '15/10/2016',\n             'ends_at' => '15/12/2016',\n             'registration_opens_at' => '15/6/2016',\n             'registration_closes_at' => '15/10/2016',\n             'max_teams' => '10',\n             'max_free_agents' => '5'\n            }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationSeasonsController.php",
    "groupTitle": "League_Season"
  },
  {
    "type": "put",
    "url": "api/leagues/:leagueId/seasons/:seasonId",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "League_Season",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the league season</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "seasonId",
            "description": "<p>Id of the season</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the season</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "starts_at",
            "description": "<p>Starting date of the season</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ends_at",
            "description": "<p>Ending date of the season</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "registration_opens_at",
            "description": "<p>Registeration opening date of the season</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "registration_closes_at",
            "description": "<p>Registeration closing date of the season</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "max_teams",
            "description": "<p>Maximum team of the season</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "max_free_agents",
            "description": "<p>Maximum agents of the season</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '2',\n         'league_id' => '6',\n         'name' => 'Summer Season',\n         'stars_at' => '15/10/2016',\n         'ends_at' => '15/12/2016',\n         'registration_opens_at' => '15/6/2016',\n         'registration_closes_at' => '15/10/2016',\n         'max_teams' => '10',\n         'max_free_agents' => '5',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationSeasonsController.php",
    "groupTitle": "League_Season",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "SeasonCompetitionNotFound",
            "description": "<p>The <code>id</code> of the League season was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SeasonCompetitionNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league season does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/season-game-stats",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create_a_new_league",
    "group": "League_Season_Game_Stats",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Creates season stats for the specified league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "season_id",
            "description": "<p>ID of the season of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "game_id",
            "description": "<p>ID of the game of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "home_team_points",
            "description": "<p>Points of the home team</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "visiting_team_points",
            "description": "<p>Points of the visting team</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n             'id' => 1,\n             'location' => 'Miss Bonnie Champlin',\n             'datetime' => '2016-05-10 06:58:46',\n             'date' => '2016-05-10 06:58:46',\n             'competition_id' => 1,\n             'competition_type' => 'Finals',\n             'league_id' => 1,\n             'sport' => 'Football',\n             'home_team' => 'Real Madrid',\n             'visiting_team' => 'Barcelona',\n             'home_team_id' => 1,\n             'visiting_team_id' => 2,\n             'home_team_score' => 2,\n             'visiting_team_score' => 2,\n             'home_team_logo' => $league_photos,\n             'home_team_logo_id' => 8,\n             'visiting_team_logo' => $league_qnapVideos,\n             'visiting_team_logo_id' => 10,\n             'week' => 'Tuesday',\n         ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueSeasonGameStatsController.php",
    "groupTitle": "League_Season_Game_Stats"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/teams",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Team",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Adds a team to the league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "league_id",
            "description": "<p>ID of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "team_id",
            "description": "<p>ID of the team</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationTeamsController.php",
    "groupTitle": "League_Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "TeamNotFound",
            "description": "<p>The <code>id</code> of the team was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-TeamNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The team was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/teams/:teamId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Team",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Deletes a team from a league.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>ID of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "teamId",
            "description": "<p>ID of the team to be deleted</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationTeamsController.php",
    "groupTitle": "League_Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "UserHasNoOrganization",
            "description": "<p>The user has not an organization</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserHasNoOrganization:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"The user has not an organization\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/teams",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Team",
    "description": "<p>Returns an array of all the teams on the league that matches the filter parameters</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "order_by",
            "description": "<p>Order by</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "order_direction",
            "description": "<p>Direction of order</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "offset",
            "description": "<p>Offset</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "limit",
            "description": "<p>Limit</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationTeamsController.php",
    "groupTitle": "League_Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/:teamId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Team",
    "description": "<p>Gets a team that is part of the league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "teamId",
            "description": "<p>Id of the Team</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationTeamsController.php",
    "groupTitle": "League_Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "TeamNotFound",
            "description": "<p>The <code>id</code> of the team was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-TeamNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The team was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/passcode-invite",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Team_Passcode_Invitation",
    "description": "<p>Create a team passcode invitation</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "passCode",
            "description": "<p>Passcode</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": ['success' => 'Player invited for the league']\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationTeamPasscodeInvitesController.php",
    "groupTitle": "League_Team_Passcode_Invitation"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/team/:teamId/photos/:offset/:limit",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Team_Photos",
    "description": "<p>Returns the photos for the team of the requested league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "teamId",
            "description": "<p>Team id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "offset",
            "description": "<p>Pagination</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "limit",
            "description": "<p>Limit of the photos.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationTeamPhoto</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'id' => 1,\n             'league_id' => 3,\n             'image' => '/public/images/testphoto.jpeg',\n             'album_id' => 2,\n             'game_id' => 2,\n             'team_id' => 2,\n             'division_id' => 2,\n         },\n         {\n             'id' => 2,\n             'league_id' => 2,\n             'image' => '/public/images/testphoto.jpeg',\n             'album_id' => 2,\n             'game_id' => 2,\n             'team_id' => 2,\n             'division_id' => 2,*              }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationTeamPhotosController.php",
    "groupTitle": "League_Team_Photos"
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/videos",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "League_Video",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new Video for a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league to link the video</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Description for the video</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "video",
            "description": "<p>Video</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationVideo</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n             'id' => 1,\n             'league_id' => 1,\n             'label_id' => 3,\n             'game_id' => 2,\n             'video_id' => 1,\n             'description' => 'Jodie Gleason',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n             'size' => '81686',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $leagueTeamVideo->thumbnail_path,\n             'file_name' => 'Jodie Gleason',\n             'date' => 'Jodie Gleason',\n             'tagTeams' => 'Jodie Gleason',\n             'tagPlayers' => 'Jodie Gleason',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideosController.php",
    "groupTitle": "League_Video",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/videos/:leagueVideoId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "League_Video",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the league video</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league to link the video</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueVideoId",
            "description": "<p>League video id of the video</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideosController.php",
    "groupTitle": "League_Video",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueVideoNotFound",
            "description": "<p>The league video was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueVideoNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league video was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/videos/:leagueVideoId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "League_Video",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets a league video</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueVideoId",
            "description": "<p>Id of the League Video to retrieve</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n             'id' => 1,\n             'league_id' => 1,\n             'label_id' => 3,\n             'game_id' => 2,\n             'video_id' => 1,\n             'description' => 'Jodie Gleason',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n             'size' => '81686',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $leagueTeamVideo->thumbnail_path,\n             'file_name' => 'Jodie Gleason',\n             'date' => 'Jodie Gleason',\n             'tagTeams' => 'Jodie Gleason',\n             'tagPlayers' => 'Jodie Gleason',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideosController.php",
    "groupTitle": "League_Video",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueVideoNotFound",
            "description": "<p>The league video was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueVideoNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league video was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/leagues/:leagueId/videos/:leagueVideoId",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "League_Video",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the league video</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>League id of the league to link the video</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueVideoId",
            "description": "<p>League video id of the video</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Description for the video</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "video",
            "description": "<p>Video</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n             'id' => 1,\n             'league_id' => 1,\n             'label_id' => 3,\n             'game_id' => 2,\n             'video_id' => 1,\n             'description' => 'Jodie Gleason',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n             'size' => '81686',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $leagueTeamVideo->thumbnail_path,\n             'file_name' => 'Jodie Gleason',\n             'date' => 'Jodie Gleason',\n             'tagTeams' => 'Jodie Gleason',\n             'tagPlayers' => 'Jodie Gleason',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideosController.php",
    "groupTitle": "League_Video",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueVideoNotFound",
            "description": "<p>The league video was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueVideoNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league video was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/videoLabel",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "permission": [
      {
        "name": "organization, organization staff, JWT Auth"
      }
    ],
    "group": "League_Video_Labels",
    "description": "<p>Creates the video label</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "label_name",
            "description": "<p>Name of the label</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationVideoLabels</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => \"Label created successfully!\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideoLabelsController.php",
    "groupTitle": "League_Video_Labels",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/videoLabel/delete/:lable_id",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "permission": [
      {
        "name": "organization, organization staff, JWT Auth"
      }
    ],
    "group": "League_Video_Labels",
    "description": "<p>Returns the League Video Labels</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "lable_id",
            "description": "<p>Id of the video label</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "label_name",
            "description": "<p>Name of the label</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueOrganizationVideoLabels</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => \"Label deleted successfully!\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideoLabelsController.php",
    "groupTitle": "League_Video_Labels",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/videoLabel",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "permission": [
      {
        "name": "organization, organization staff, JWT Auth"
      }
    ],
    "group": "League_Video_Labels",
    "description": "<p>Returns the LeagueOrganization Video Labels</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueVideoLabels</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         {\n             'id' => 1,\n             'name' => 'Finals',\n         },\n         {\n             'id' => 2,\n             'name' => 'Semi-Finals',\n         }\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideoLabelsController.php",
    "groupTitle": "League_Video_Labels",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/videoLabel/:lable_id",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "permission": [
      {
        "name": "organization, organization staff, JWT Auth"
      }
    ],
    "group": "League_Video_Labels",
    "description": "<p>Updates the requested video label</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "lable_id",
            "description": "<p>Id of the video label</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "label_name",
            "description": "<p>Name of the label</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>LeagueVideoLabels</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => \"Label update successfully!\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideoLabelsController.php",
    "groupTitle": "League_Video_Labels",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/leagues/:leagueId/deletePublishedLeagueVideos",
    "title": "deletePublishedVideos",
    "version": "1.0.0",
    "name": "deletePublishedVideos",
    "group": "League_Video",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the Published league video</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "videos",
            "description": "<p>Videos to be published</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideosController.php",
    "groupTitle": "League_Video",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueVideoNotFound",
            "description": "<p>The league video was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueVideoNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league video was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/leagues/:leagueId/publishLeagueVideos",
    "title": "publishVideos",
    "version": "1.0.0",
    "name": "publishVideos",
    "group": "League_Video",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Publish the league video</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the League</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "videos",
            "description": "<p>Videos to be published</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "players",
            "description": "<p>Players to be tagged</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "teams",
            "description": "<p>Teams of the leagues attached</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Published successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideosController.php",
    "groupTitle": "League_Video",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueVideoNotFound",
            "description": "<p>The league video was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueVideoNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league video was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/videos",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "League_Videos",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Returns all videos for a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "leagueId",
            "description": "<p>Id of the league</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Collection",
            "optional": false,
            "field": "array",
            "description": "<p>Collection with all the videos.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  [\n             'id' => 1,\n             'league_id' => 1,\n             'label_id' => 3,\n             'game_id' => 2,\n             'video_id' => 1,\n             'description' => 'Jodie Gleason',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n             'size' => '81686',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $leagueTeamVideo->thumbnail_path,\n             'file_name' => 'Jodie Gleason',\n             'date' => 'Jodie Gleason',\n             'tagTeams' => 'Jodie Gleason',\n             'tagPlayers' => 'Jodie Gleason',\n  ],\n  [\n             'id' => 2,\n             'league_id' => 2,\n             'label_id' => 2,\n             'game_id' => 2,\n             'video_id' => 1,\n             'description' => 'Jodie Gleason',\n             'mime_type' => 'application/vnd.lotus-screencam',\n             'extension' => 'igl',\n             'size' => '81686',\n             'file_path' => '/public/videos/testvideowooter.mp4',\n             'thumbnail_path' => $leagueTeamVideo->thumbnail_path,\n             'file_name' => 'Jodie Gleason',\n             'date' => 'Jodie Gleason',\n             'tagTeams' => 'Jodie Gleason',\n             'tagPlayers' => 'Jodie Gleason',*       ],\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationVideosController.php",
    "groupTitle": "League_Videos",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> of the League was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueVideoNotFound",
            "description": "<p>The league video was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "LeagueNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This league does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueVideoNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The league video was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/authenticate",
    "title": "POST",
    "version": "1.0.0",
    "name": "authenticate",
    "group": "Login",
    "description": "<p>Logins a user</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email of the user</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>Password of the user</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'token' => JAuth token\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "invalidCredentials",
            "description": ""
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserDeactivated",
            "description": ""
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "JWTException",
            "description": ""
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/AuthenticateController.php",
    "groupTitle": "Login"
  },
  {
    "type": "post",
    "url": "api/players",
    "title": "Create",
    "name": "Create",
    "group": "Player",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Creates a new Player</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email, must be unique</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "first_name",
            "description": "<p>First name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "last_name",
            "description": "<p>Last name of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "phone",
            "description": "<p>Phone number</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "birthday",
            "description": "<p>Birthday</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "gender",
            "description": "<p>Gender 'in:male,female,other'</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": true,
            "field": "picture",
            "description": "<p>Picture of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "league_id",
            "description": "<p>ID of the League that the player is being added to</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "team_id",
            "description": "<p>ID of the Team that the player is being added to</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>User</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     {\n     'data' =>\n     [\n         'id' => $player->id,\n         'email' => $player->email,\n         'first_name' => $player->first_name,\n         'last_name' => $player->last_name,\n         'phone' => $player->phone,\n         'birthday' => $player->birthday,\n         'gender' => $player->gender,\n         'picture' => $player->picture,\n         'school' => $player->school,\n         'position' => $player->position,\n         'city' => $player->city,\n         'state' => $player->state,\n         'name' => $player->first_name . ' ' . $player->last_name,\n         'teams' => CollectionOfTeams\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayersController.php",
    "groupTitle": "Player"
  },
  {
    "type": "delete",
    "url": "api/players/:playerId",
    "title": "Delete",
    "name": "Delete",
    "group": "Player",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Deletes the player</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_id",
            "description": "<p>ID of the Player to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayersController.php",
    "groupTitle": "Player",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> player (the user_id) was not found.</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/player/change-password",
    "title": "changePassword",
    "version": "1.0.0",
    "name": "changePassword",
    "group": "PlayerInfo",
    "permission": [
      {
        "name": "Requires JWT"
      }
    ],
    "description": "<p>Updates a player password</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_id",
            "description": "<p>ID of the player to update</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "old_password",
            "description": "<p>Old password of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>New password of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "confirm_password",
            "description": "<p>Confirm password of the player</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'data' => 'Password changed successfully',\n         'message' => 'Password changed successfully',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "PlayerNotFound",
            "description": ""
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": ""
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NotPermissionException",
            "description": ""
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Player/PlayerInfoController.php",
    "groupTitle": "PlayerInfo"
  },
  {
    "type": "put",
    "url": "api/player/info",
    "title": "updateInfo",
    "version": "1.0.0",
    "name": "updateInfo",
    "group": "PlayerInfo",
    "permission": [
      {
        "name": "Requires JWT"
      }
    ],
    "description": "<p>Updates player information</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_id",
            "description": "<p>ID of the player to update</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "firstName",
            "description": "<p>First name of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lastName",
            "description": "<p>Last name of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>Phone of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "birthday",
            "description": "<p>Birthday of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>City of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>State of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "position",
            "description": "<p>Position of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "school",
            "description": "<p>School of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "Enum",
            "optional": false,
            "field": "gender",
            "description": "<p>Gender of the player</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => $player->id,\n             'email' => $player->email,\n             'first_name' => 'John',\n             'last_name' => 'Doe',\n             'phone' => $player->phone,\n             'gender' => $player->gender,\n             'picture' => $player->picture,\n             'school' => $player->school,\n             'position' => $player->position,\n             'city' => $player->city,\n             'state' => $player->state,\n             'name' => 'John Doe',\n             'current_team' => $current_team\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "PlayerNotFound",
            "description": ""
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": ""
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NotPermissionException",
            "description": ""
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Player/PlayerInfoController.php",
    "groupTitle": "PlayerInfo"
  },
  {
    "type": "get",
    "url": "api/players/:playerId",
    "title": "Read",
    "name": "Read",
    "group": "Player",
    "description": "<p>Gets a player</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_id",
            "description": "<p>Id of the Player</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => $player->id,\n         'email' => $player->email,\n         'first_name' => $player->first_name,\n         'last_name' => $player->last_name,\n         'phone' => $player->phone,\n         'birthday' => $player->birthday,\n         'gender' => $player->gender,\n         'picture' => $player->picture,\n         'school' => $player->school,\n         'position' => $player->position,\n         'city' => $player->city,\n         'state' => $player->state,\n         'name' => $player->first_name . ' ' . $player->last_name,\n         'teams' => CollectionOfTeams\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayersController.php",
    "groupTitle": "Player",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> player (the user_id) was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/players/:playerId",
    "title": "Update",
    "name": "Update",
    "group": "Player",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Updates the player</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email, must be unique</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "first_name",
            "description": "<p>First name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "last_name",
            "description": "<p>Last name of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "phone",
            "description": "<p>Phone number</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "birthday",
            "description": "<p>Birthday</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "gender",
            "description": "<p>Gender 'in:male,female,other'</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": true,
            "field": "picture",
            "description": "<p>Picture of the player</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "league_id",
            "description": "<p>ID of the League that the player is being added to</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "team_id",
            "description": "<p>ID of the Team that the player is being added to</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => $player->id,\n         'email' => $player->email,\n         'first_name' => $player->first_name,\n         'last_name' => $player->last_name,\n         'phone' => $player->phone,\n         'birthday' => $player->birthday,\n         'gender' => $player->gender,\n         'picture' => $player->picture,\n         'school' => $player->school,\n         'position' => $player->position,\n         'city' => $player->city,\n         'state' => $player->state,\n         'name' => $player->first_name . ' ' . $player->last_name,\n         'teams' => CollectionOfTeams\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayersController.php",
    "groupTitle": "Player",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "DivisionNotFound",
            "description": "<p>The <code>id</code> of the division was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "LeagueNotBelongToUser",
            "description": "<p>The user do not have access to the league</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-DivisionNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The division was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "LeagueNotBelongToUser:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have access to this league\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/player-award",
    "title": "Create",
    "name": "Create",
    "group": "Player_Award",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new relation between a player and an award</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_id",
            "description": "<p>ID of the player.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "award_id",
            "description": "<p>ID of the award.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>PlayerAward</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'player_id' => '1',\n         'award_id' => '2',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerAwardsController.php",
    "groupTitle": "Player_Award",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> player (the user_id) was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "AwardNotFound",
            "description": "<p>The <code>id</code> of the Award was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-AwardNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The award was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/player-award/:playerAwardId",
    "title": "Delete",
    "name": "Delete",
    "group": "Player_Award",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the player award relation</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Id",
            "description": "<p>of the league video to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' => 'Deleted'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerAwardsController.php",
    "groupTitle": "Player_Award",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerAwardNotFound",
            "description": "<p>The <code>id</code> of the relation between the player and the award was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-PlayerAwardNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This award was not found in this player\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/player-award/:playerAwardId",
    "title": "Read",
    "name": "Read",
    "group": "Player_Award",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets a relation between a player and an award</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "award_id",
            "description": "<p>Id of the award</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'id' => '6',\n         'player_id' => '1',\n         'award_id' => '2',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerAwardsController.php",
    "groupTitle": "Player_Award",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerAwardNotFound",
            "description": "<p>The <code>id</code> of the relation between the player and the award was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-PlayerAwardNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This award was not found in this player\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/player-award/:playerAwardId",
    "title": "Update",
    "name": "Update",
    "group": "Player_Award",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the player award relation</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_award_id",
            "description": "<p>Id of the award</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_id",
            "description": "<p>ID of the player.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "award_id",
            "description": "<p>ID of the award.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'id' => '6',\n         'player_id' => '1',\n         'award_id' => '2',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerAwardsController.php",
    "groupTitle": "Player_Award",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerAwardNotFound",
            "description": "<p>The <code>id</code> of the relation between the player and the award was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "AwardNotFound",
            "description": "<p>The <code>id</code> of the Award was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> player (the user_id) was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-PlayerAwardNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This award was not found in this player\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-AwardNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The award was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/player-sport-like",
    "title": "Create",
    "name": "Create",
    "group": "Player_Sport_Like",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Express a sport that the player likes</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_id",
            "description": "<p>ID of the player.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sport_id",
            "description": "<p>ID of the sport.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>PlayerSport</p>"
          },
          {
            "group": "Success 200",
            "optional": false,
            "field": "player_id",
            "description": "<p>The id of the player related to the sport the user likes</p>"
          },
          {
            "group": "Success 200",
            "optional": false,
            "field": "sport_id",
            "description": "<p>The id of the sport the user liked</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'player_id' => '1',\n         'sport_id' => '2',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerSportLikeController.php",
    "groupTitle": "Player_Sport_Like",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> player (the user_id) was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "SportNotFound",
            "description": "<p>The <code>id</code> of the Sport was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-SportNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"SportNotFound\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/player-sport-like/:playerSportLike",
    "title": "Delete",
    "name": "Delete",
    "group": "Player_Sport_Like",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the player sport like relation</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_sport_like_id",
            "description": "<p>Id of the Player Sport Like relation</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' => 'Deleted'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerSportLikeController.php",
    "groupTitle": "Player_Sport_Like",
    "error": {
      "fields": {
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DeleteException",
            "description": "<p>There was an error when deleting from the database</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ],
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerSportLikeNotFound",
            "description": "<p>The <code>id</code> of the relation between the player and the sport the player likes was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-DeleteException:",
          "content": "HTTP/1.1 500 Internal Error\n{\n  \"error\": {\n         \"message\": \"There was an error while deleting the record in the database\"\n         \"status_code\": 500\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-PlayerSportLikeNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"PlayerSportLikeNotFound\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/player-sport-like/:playerSportLikeId",
    "title": "Read",
    "name": "Read",
    "group": "Player_Sport_Like",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets the relation from a sport that the player likes</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_sport_like_id",
            "description": "<p>Id of the Player Sport Like relation</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'id' => '2',\n         'player_id' => '1',\n         'sport_id' => '2',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerSportLikeController.php",
    "groupTitle": "Player_Sport_Like",
    "error": {
      "fields": {
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ],
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerSportLikeNotFound",
            "description": "<p>The <code>id</code> of the relation between the player and the sport the player likes was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-PlayerSportLikeNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"PlayerSportLikeNotFound\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/player-sport-like/:playerSportLikeId",
    "title": "Update",
    "name": "Update",
    "group": "Player_Sport_Like",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the player sport like relation</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_sport_like_id",
            "description": "<p>Id of the Player Sport Like relation</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "player_id",
            "description": "<p>The id of the player related to the sport the user likes</p>"
          },
          {
            "group": "Success 200",
            "optional": false,
            "field": "sport_id",
            "description": "<p>The id of the sport the user liked</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'id' => '2',\n         'player_id' => '1',\n         'sport_id' => '2',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerSportLikeController.php",
    "groupTitle": "Player_Sport_Like",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "SportNotFound",
            "description": "<p>The <code>id</code> of the Sport was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> player (the user_id) was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerSportLikeNotFound",
            "description": "<p>The <code>id</code> of the relation between the player and the sport the player likes was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-SportNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"SportNotFound\"\n}",
          "type": "json"
        },
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-PlayerSportLikeNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"PlayerSportLikeNotFound\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/player-stat",
    "title": "Create",
    "name": "Create",
    "group": "Player_Stat",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Express a stat for a user</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_id",
            "description": "<p>ID of the player.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "stat_id",
            "description": "<p>ID of the sport.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>PlayerStat</p>"
          },
          {
            "group": "Success 200",
            "optional": false,
            "field": "player_id",
            "description": "<p>The id of the player</p>"
          },
          {
            "group": "Success 200",
            "optional": false,
            "field": "stat_id",
            "description": "<p>The id of the stat of the user</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'player_id' => '1',\n         'stat_id' => '2',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerStatsController.php",
    "groupTitle": "Player_Stat",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> player (the user_id) was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "StatNotFound",
            "description": "<p>The <code>id</code> of the Stat was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-StatNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"StatNotFound\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/player-stat/:playerStatId",
    "title": "Delete",
    "name": "Delete",
    "group": "Player_Stat",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the player stat relation</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_stat_id",
            "description": "<p>Id of the player stat to delete</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' => 'Deleted'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerStatsController.php",
    "groupTitle": "Player_Stat",
    "error": {
      "fields": {
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DeleteException",
            "description": "<p>There was an error when deleting from the database</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ],
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerStatNotFound",
            "description": "<p>The <code>id</code> of the relation between the player and the stat was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-DeleteException:",
          "content": "HTTP/1.1 500 Internal Error\n{\n  \"error\": {\n         \"message\": \"There was an error while deleting the record in the database\"\n         \"status_code\": 500\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-PlayerStatNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"PlayerStatNotFound\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/player-stat/:playerStatId",
    "title": "Read",
    "name": "Read",
    "group": "Player_Stat",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets a player stat relation</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_stat_id",
            "description": "<p>Id of the Player Stat relation</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'id' => '2',\n         'player_id' => '1',\n         'stat_id' => '2',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerStatsController.php",
    "groupTitle": "Player_Stat",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerStatNotFound",
            "description": "<p>The <code>id</code> of the relation between the player and the stat was not found</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-PlayerStatNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"PlayerStatNotFound\"\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/player-stat/:playerStatId",
    "title": "Update",
    "name": "Update",
    "group": "Player_Stat",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the player stat relation</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_stat_id",
            "description": "<p>Id of the player league relation</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_id",
            "description": "<p>ID of the player.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "stat_id",
            "description": "<p>ID of the stat.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'id' => '6',\n         'player_id' => '1',\n         'stat_id' => '2',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Player/PlayerStatsController.php",
    "groupTitle": "Player_Stat",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "StatNotFound",
            "description": "<p>The <code>id</code> of the Stat was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> player (the user_id) was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "PlayerStatNotFound",
            "description": "<p>The <code>id</code> of the relation between the player and the stat was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-StatNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"StatNotFound\"\n}",
          "type": "json"
        },
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-PlayerStatNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"PlayerStatNotFound\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/player-stats-averages",
    "title": "Index",
    "version": "1.0.0",
    "name": "Player_Stats_Averages",
    "group": "Player_Stats_Averages",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Returns that stats averages of players</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "leagueId",
            "description": "<p>The id of the league that the player stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "offset",
            "description": "<p>The amount to offset the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "limit",
            "description": "<p>The amount to limit the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "order_by",
            "description": "<p>The parameter to order the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "order_direction",
            "description": "<p>The direction to order the results in.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport",
            "description": "<p>The sport that the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "type",
            "description": "<p>The type of the stats.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "stat_name",
            "description": "<p>The name of a single stat to return.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "bulk",
            "description": "<p>Notifies the api whether or not to return the results in bulk.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "competition_id",
            "description": "<p>Tge id of the competition that the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "game_id",
            "description": "<p>The id of the game tgat the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "team_id",
            "description": "<p>The id of the team that tge stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "player_id",
            "description": "<p>The id of the player tgat the stats belong to.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>PlayerStatsAverages</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => [\n         'all' => [\n             [\n                 'averages' => [\n                            'PPG' => 0,\n                            'FG' => 0,\n                            'FGA' => 0,\n                            '3FG' => 0,\n                            '3FGA' => 0,\n                            'FT' => 0,\n                            'FTA' => 0,\n                            'OFFR' => 0,\n                            'DEFR' => 0,\n                            'AST' => 0,\n                            'TURN' => 0,\n                            'STL' => 0,\n                            'BLK' => 0,\n                            'FL' => 0,\n                            'total_games' => 0,\n                            'PPG_rank' => 0,\n                            'FG_rank' => 0,\n                            '3FG_rank' => 0,\n                            '3FGA_rank' => 0,\n                            'FT_rank' => 0,\n                            'FTA_rank' => 0,\n                            'OFFR_rank' => 0,\n                            'DEFR_rank' => 0,\n                            'AST_rank' => 0,\n                            'TURN_rank' => 0,\n                            'STL_rank' => 0,\n                            'BLK_rank' => 0,\n                            'FL_rank' => 0\n                        ],\n                        'name' => 'Michael Jordan',\n                        'jersey' => 23,\n                        'player_id => 1\n             ]\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationPlayerStatsAveragesController.php",
    "groupTitle": "Player_Stats_Averages"
  },
  {
    "type": "post",
    "url": "api/players/:playerId/teams",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "Player_Team",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Links a player with a team</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "team_id",
            "description": "<p>ID of the team</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "competition_id",
            "description": "<p>ID of the competition</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "competition_type",
            "description": "<p>Type of the competition</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ],\n     'message' => 'Success'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Player/PlayerTeamsController.php",
    "groupTitle": "Player_Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/players/:playerId/teams",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create",
    "group": "Player_Team",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Links a player with a team</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "team_id",
            "description": "<p>ID of the team</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "competition_id",
            "description": "<p>ID of the competition</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "competition_type",
            "description": "<p>Type of the competition</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ],\n     'message' => 'Success'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Player/PlayerTeamsController.php",
    "groupTitle": "Player_Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/players/:playerId/teams",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "Player_Team",
    "description": "<p>Returns an array of all the teams where a player plays that matches the filter parameters</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array with all the teams.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "player_id",
            "description": "<p>ID of the player to get the teams</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Player/PlayerTeamsController.php",
    "groupTitle": "Player_Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/players/:playerId/teams/:teamId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "Player_Team",
    "description": "<p>Gets a team that a player is playing in</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "player_id",
            "description": "<p>Id of the Player</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "team_id",
            "description": "<p>Id of the Team</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Player/PlayerTeamsController.php",
    "groupTitle": "Player_Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "TeamNotFound",
            "description": "<p>The <code>id</code> of the team was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-TeamNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The team was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "register",
    "title": "Create",
    "version": "1.0.0",
    "name": "register",
    "group": "Registration",
    "description": "<p>Registers a new user</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "preselected_role",
            "description": "<p>Role of the user</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email of the user</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>Password of the user</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "first_name",
            "description": "<p>First name of the user</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "last_name",
            "description": "<p>Last name of the user</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "birthday",
            "description": "<p>Birthday of the user</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>Phone of the user</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<p>Gender of the user</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => $user->id,\n             'email' => $user->email,\n             'first_name' => 'John',\n             'last_name' => 'Doe',\n             'phone' => $user->phone,\n             'gender' => $user->gender,\n             'picture' => $user->picture,\n             'active' => 1,\n             'birthday' => $user->birthday,\n             'is_organization' => true,\n             'roles' => $user->roles\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/RegisterController.php",
    "groupTitle": "Registration"
  },
  {
    "type": "get",
    "url": "scheduledemo",
    "title": "Index",
    "name": "Index",
    "group": "Schedule",
    "description": "<p>Returns an array of schedules</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array with all the schedules.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'id' => 1,\n             'name' => $schedule_name,\n             'email' => $schedule_email,\n             'phpne' => $schedule_phone,\n             'comments' => $schedule_comments,\n             'created_at' => $schedule_created_at,\n             'updated_at' => $schedule_updated_at\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ScheduleDemoController.php",
    "groupTitle": "Schedule"
  },
  {
    "type": "get",
    "url": "scheduledemo",
    "title": "Store",
    "name": "Store",
    "group": "Schedule",
    "description": "<p>Returns the status of the stored schedule</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>containing the status of the stored schedule</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "HTTP/1.1 200 OK\n{\n     \"data\": [\n         [\n             'status' => $schedule_status\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "name",
            "description": "<p>The name of the schedule</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "email",
            "description": "<p>The email of the schedule</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "phone",
            "description": "<p>The phone number for the schedule</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "comments",
            "description": "<p>Comments regarding the schedule</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ScheduleDemoController.php",
    "groupTitle": "Schedule"
  },
  {
    "type": "post",
    "url": "api/stat",
    "title": "Create",
    "name": "Create",
    "group": "Stat",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Creates a new Stat</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "metric",
            "description": "<p>Metric of the stat</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "points_scored",
            "description": "<p>Points obtained in the stat</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>Stat</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'metric' => 'Goal',\n         'points_scored' => '1',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Stat/StatsController.php",
    "groupTitle": "Stat"
  },
  {
    "type": "delete",
    "url": "api/stat/:statId",
    "title": "Delete",
    "name": "Delete",
    "group": "Stat",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Deletes the stat</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "stat_id",
            "description": "<p>Id of the stat</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' => 'Deleted'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Stat/StatsController.php",
    "groupTitle": "Stat"
  },
  {
    "type": "get",
    "url": "api/stat/:statId",
    "title": "Read",
    "name": "Read",
    "group": "Stat",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Gets an stat</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "stat_id",
            "description": "<p>Id of the stat</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'id' => '6',\n         'metric' => 'Goal',\n         'points_scored' => '1',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Stat/StatsController.php",
    "groupTitle": "Stat"
  },
  {
    "type": "put",
    "url": "api/stat/:statId",
    "title": "Update",
    "name": "Update",
    "group": "Stat",
    "permission": [
      {
        "name": "organization, organization staff, admin"
      }
    ],
    "description": "<p>Updates the stat</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "stat_id",
            "description": "<p>Id of the stat</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "award_id",
            "description": "<p>Id of the stat</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the stat.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'success' => true,\n     'error' => false,\n     'content' =>\n     [\n         'id' => '6',\n         'metric' => 'Goal',\n         'points_scored' => '1',\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/API/Stat/StatsController.php",
    "groupTitle": "Stat"
  },
  {
    "type": "post",
    "url": "api/teams/:teamId/players",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create_a_new_player_for_a_team",
    "group": "Team",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Creates a new team</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "array/Number",
            "optional": false,
            "field": "players",
            "description": "<p>Players to be added to the team</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "competition_id",
            "description": "<p>ID of the competition of the team</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "competition_type",
            "description": "<p>Type of the competition of the team</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'message' =>\n     [\n         'Success'\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Team/TeamPlayersController.php",
    "groupTitle": "Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "TeamNotFound",
            "description": "<p>The <code>id</code> of the team was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "LeagueNotFound",
            "description": "<p>The <code>id</code> player (the user_id) was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "NotPermissionException",
            "description": "<p>The user has no permission to perform this action</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "Error-TeamNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The team was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "PlayerNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The player was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "NotPermissionException",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"You do not have permission to perform this action\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "api/teams",
    "title": "Create",
    "version": "1.0.0",
    "name": "Create_a_new_team",
    "group": "Team",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Creates a new team</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>The name of the team</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sport_id",
            "description": "<p>ID of the sport that the team plays</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": true,
            "field": "cover_photo",
            "description": "<p>File of the cover photo</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": true,
            "field": "logo",
            "description": "<p>File of the logo</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "description",
            "description": "<p>Description of the team</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "captain_id",
            "description": "<p>ID of the user that will be the captain of the team</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Team/TeamsController.php",
    "groupTitle": "Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "api/teams/:teamId",
    "title": "Delete",
    "version": "1.0.0",
    "name": "Delete",
    "group": "Team",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Deletes a team</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "team_id",
            "description": "<p>ID of the team to be deleted</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => 'Deleted successfully'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Team/TeamsController.php",
    "groupTitle": "Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "TeamNotFound",
            "description": "<p>The <code>id</code> of the team was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ],
        "Error 500": [
          {
            "group": "Error 500",
            "optional": false,
            "field": "DatabaseException",
            "description": "<p>Error with the DB</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "UserHasNoOrganization",
            "description": "<p>The user has not an organization</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-TeamNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The team was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "DatabaseException:",
          "content": "HTTP/1.1 500 Server Error\n{\n  \"error\": {\n         \"message\": \"Error with the DB\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserHasNoOrganization:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"The user has not an organization\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/teams",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "Team",
    "description": "<p>Returns an array of all the teams that matches the filter parameters</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>Array with all the teams.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "player_id",
            "description": "<p>ID of the player to get the teams</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/API/Team/TeamsController.php",
    "groupTitle": "Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/teams/:teamId",
    "title": "Read",
    "version": "1.0.0",
    "name": "Read",
    "group": "Team",
    "description": "<p>Gets a team</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "team_id",
            "description": "<p>Id of the Team</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Team/TeamsController.php",
    "groupTitle": "Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "TeamNotFound",
            "description": "<p>The <code>id</code> of the team was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-TeamNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The team was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "api/teams/:teamId",
    "title": "Update",
    "version": "1.0.0",
    "name": "Update",
    "group": "Team",
    "permission": [
      {
        "name": "Requires JWT. User needs to be organization"
      }
    ],
    "description": "<p>Updates a team</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>The name of the team</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": true,
            "field": "cover_photo",
            "description": "<p>File of the cover photo</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": true,
            "field": "logo",
            "description": "<p>File of the logo</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "description",
            "description": "<p>Description of the team</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "captain_id",
            "description": "<p>ID of the user that will be the captain of the team</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => '6',\n         'sport' => $sportObject,\n         'captain' => $userObject,\n         'logo' => $imageObject,\n         'cover_photo' => $imageObject,\n         'players' => $collectionOfUsers,\n         'division' => $divisionObject,\n         'name' => 'Real Madrid',\n         'description' => 'Team of Madrid, Spain',\n         'wins' => 20,\n         'loss' => 15,\n         'ties' => 5,\n         'played' => 40,\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Team/TeamsController.php",
    "groupTitle": "Team",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "TeamNotFound",
            "description": "<p>The <code>id</code> of the team was not found</p>"
          },
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ],
        "Error 403": [
          {
            "group": "Error 403",
            "optional": false,
            "field": "UserHasNoOrganization",
            "description": "<p>The user has not an organization</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-TeamNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The team was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        },
        {
          "title": "UserHasNoOrganization:",
          "content": "HTTP/1.1 403 Forbidden\n{\n  \"error\": {\n         \"message\": \"The user has not an organization\"\n         \"status_code\": 403\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/teams/:teamId/players",
    "title": "Index",
    "version": "1.0.0",
    "name": "Index",
    "group": "Team_Players",
    "permission": [
      {
        "name": "Requires JWT."
      }
    ],
    "description": "<p>Returns an array of all the players that are in a team filtered by parameters</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "order_by",
            "description": "<p>Order by</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "order_direction",
            "description": "<p>Direction of order</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "offset",
            "description": "<p>Offset</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "limit",
            "description": "<p>Limit</p>"
          },
          {
            "group": "Parameter",
            "type": "decimal",
            "optional": true,
            "field": "competition_type",
            "description": "<p>Type of the competition of the team</p>"
          },
          {
            "group": "Parameter",
            "type": "decimal",
            "optional": true,
            "field": "competition_id",
            "description": "<p>ID of the competition where the team plays</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' =>\n     [\n         'id' => $player->id,\n         'email' => $player->email,\n         'first_name' => $player->first_name,\n         'last_name' => $player->last_name,\n         'phone' => $player->phone,\n         'birthday' => $player->birthday,\n         'gender' => $player->gender,\n         'picture' => $player->picture,\n         'school' => $player->school,\n         'position' => $player->position,\n         'city' => $player->city,\n         'state' => $player->state,\n         'name' => $player->first_name . ' ' . $player->last_name,\n         'teams' => CollectionOfTeams\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Team/TeamPlayersController.php",
    "groupTitle": "Team_Players",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "TeamNotFound",
            "description": "<p>The <code>id</code> of the team was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-TeamNotFound:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"The team was not found\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/team-stats-averages",
    "title": "Index",
    "version": "1.0.0",
    "name": "Team_Stats_Averages",
    "group": "Team_Stats_Averages",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Returns that stats averages of teams in a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "leagueId",
            "description": "<p>The id of the league that the team stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "offset",
            "description": "<p>The amount to offset the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "limit",
            "description": "<p>The amount to limit the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "order_by",
            "description": "<p>The parameter to order the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "order_direction",
            "description": "<p>The direction to order the results in.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport",
            "description": "<p>The sport that the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "type",
            "description": "<p>The type of the stats.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "bulk",
            "description": "<p>Notifies the api whether or not to return the results in bulk.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "team_id",
            "description": "<p>The id of the competition that the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "season_id",
            "description": "<p>The id of the game tgat the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "stage_id",
            "description": "<p>The id of the team that tge stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "game_id",
            "description": "<p>The id of the player tgat the stats belong to.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>TeamStatsAverages</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => [\n         'stats' => [\n             'first_quarter_points' => 0,\n                    'second_quarter_points' => 0,\n                    'third_quarter_points' => 0,\n                    'fourth_quarter_points' => 0,\n                    'points' => 0,\n                    'wins' => 0,\n                    'loss' => 0,\n                    'draw' => 0,\n                    'GB' => 0,\n             'player_stats' => [\n                        'PTS' => 0,\n                        'FG' => 0,\n                        'FGA' => 0,\n                        '3FG' => 0,\n                        '3FGA' => 0,\n                        'FT' => 0,\n                        'FTA' => 0,\n                        'OFFRB' => 0,\n                        'DEFRB' => 0,\n                        'AST' => 0,\n                        'TURN' => 0,\n                        'STL' => 0,\n                        'BLK' => 0,\n                        'FL' => 0\n             ]\n         ],\n         'team_id' => 1,\n         'team_name' => 'Bears',\n         'team_logo' => 'path/to/logo',\n         'team_logo_thumbnail' => 'path/to/logo_thumbnail',\n         'team_divisions' => [\n             [\n                 'name' => 'North Division'\n             ]\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationTeamStatsAveragesController.php",
    "groupTitle": "Team_Stats_Averages"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/team-stats-percentages",
    "title": "Index",
    "version": "1.0.0",
    "name": "Team_Stats_Percentages",
    "group": "Team_Stats_Percentages",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Returns that stats percentages of teams in a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "leagueId",
            "description": "<p>The id of the league that the team stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "offset",
            "description": "<p>The amount to offset the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "limit",
            "description": "<p>The amount to limit the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "order_by",
            "description": "<p>The parameter to order the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "order_direction",
            "description": "<p>The direction to order the results in.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport",
            "description": "<p>The sport that the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "type",
            "description": "<p>The type of the stats.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "bulk",
            "description": "<p>Notifies the api whether or not to return the results in bulk.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "team_id",
            "description": "<p>The id of the competition that the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "season_id",
            "description": "<p>The id of the game tgat the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "stage_id",
            "description": "<p>The id of the team that tge stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "game_id",
            "description": "<p>The id of the player tgat the stats belong to.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>TeamStatsPercentages</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => [\n         'stats' => [\n             'first_quarter_points' => 0,\n                    'second_quarter_points' => 0,\n                    'third_quarter_points' => 0,\n                    'fourth_quarter_points' => 0,\n                    'points' => 0,\n                    'wins' => 0,\n                    'loss' => 0,\n                    'draw' => 0,\n                    'GB' => 0\n         ],\n         'team_id' => 1,\n         'team_name' => 'Bears',\n         'team_logo' => 'path/to/logo',\n         'team_logo_thumbnail' => 'path/to/logo_thumbnail',\n         'team_divisions' => [\n             [\n                 'name' => 'North Division'\n             ]\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationTeamStatsPercentagesController.php",
    "groupTitle": "Team_Stats_Percentages"
  },
  {
    "type": "get",
    "url": "api/leagues/:leagueId/team-stats-totals",
    "title": "Index",
    "version": "1.0.0",
    "name": "Team_Stats_Totals",
    "group": "Team_Stats_Totals",
    "permission": [
      {
        "name": "organization, organization staff, JWTAuth"
      }
    ],
    "description": "<p>Returns that stats totals of teams in a league</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "leagueId",
            "description": "<p>The id of the league that the team stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "offset",
            "description": "<p>The amount to offset the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "limit",
            "description": "<p>The amount to limit the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "order_by",
            "description": "<p>The parameter to order the results by.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "order_direction",
            "description": "<p>The direction to order the results in.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sport",
            "description": "<p>The sport that the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "type",
            "description": "<p>The type of the stats.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "bulk",
            "description": "<p>Notifies the api whether or not to return the results in bulk.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "team_id",
            "description": "<p>The id of the competition that the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "season_id",
            "description": "<p>The id of the game tgat the stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "stage_id",
            "description": "<p>The id of the team that tge stats belong to.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "game_id",
            "description": "<p>The id of the player tgat the stats belong to.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "Object",
            "description": "<p>TeamStatsTotals</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => [\n         'stats' => [\n             'first_quarter_points' => 0,\n                    'second_quarter_points' => 0,\n                    'third_quarter_points' => 0,\n                    'fourth_quarter_points' => 0,\n                    'points' => 0,\n                    'wins' => 0,\n                    'loss' => 0,\n                    'draw' => 0,\n                    'GB' => 0\n         ],\n         'team_id' => 1,\n         'team_name' => 'Bears',\n         'team_logo' => 'path/to/logo',\n         'team_logo_thumbnail' => 'path/to/logo_thumbnail',\n         'team_divisions' => [\n             [\n                 'name' => 'North Division'\n             ]\n         ]\n     ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/API/Organization/League/LeagueOrganizationTeamStatsTotalsController.php",
    "groupTitle": "Team_Stats_Totals"
  },
  {
    "type": "get",
    "url": "admin/user-management/login-as/:userId",
    "title": "loginAs",
    "version": "1.0.0",
    "name": "loginAs",
    "group": "User_Authentication",
    "description": "<p>Returns the JWT token against user id</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "userId",
            "description": "<p>Id of the user.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => $token\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/UserManagementController.php",
    "groupTitle": "User_Authentication",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "admin/user-management/login-as-facebook/:facebookUserId",
    "title": "loginAsFacebookUser",
    "version": "1.0.0",
    "name": "loginAsFacebookUser",
    "group": "User_Authentication",
    "description": "<p>Returns the JWT token against facebook id</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "facebookUserId",
            "description": "<p>Facebook id of the user.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success:",
          "content": "HTTP/1.1 200 OK\n{\n     'data' => $token\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Admin/UserManagementController.php",
    "groupTitle": "User_Authentication",
    "error": {
      "fields": {
        "Error 404": [
          {
            "group": "Error 404",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": {\n         \"message\": \"This user does not exist\"\n         \"status_code\": 404\n   }\n}",
          "type": "json"
        }
      ]
    }
  }
] });
