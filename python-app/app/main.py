from typing import Union
from fastapi import FastAPI, APIRouter, Response, Request
from fastapi.middleware.cors import CORSMiddleware
from starlette.background import BackgroundTask
from fastapi.routing import APIRoute
from starlette.types import Message
from typing import Dict, Any
import logging

from metrics import *

app = FastAPI(docs_url="/")

logging.basicConfig(filename='info.log', level=logging.DEBUG)
    
async def set_body(request: Request, body: bytes):
    async def receive() -> Message:
        return {'type': 'http.request', 'body': body}
    request._receive = receive
    
@app.post("/version")
async def version():
    return {"version": app.version}
    
def log_info(req_body, res_body):
    logging.info(req_body)
    logging.info(res_body)

origins = [
    "https://alec.develop:4445",
    "http://alec.develop:4445",
    "http://localhost",
    "http://localhost:4445",
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.middleware('http')
async def some_middleware(request: Request, call_next):
    req_body = await request.body()
    await set_body(request, req_body)
    response = await call_next(request)
    
    res_body = b''
    async for chunk in response.body_iterator:
        res_body += chunk
    
    task = BackgroundTask(log_info, req_body, res_body)
    return Response(content=res_body, status_code=response.status_code, 
        headers=dict(response.headers), media_type=response.media_type, background=task)

# @app.get("/")
# def read_root():
#     return {"Hello": "World"}


@app.get("/items/{item_id}")
def read_item(item_id: int, q: Union[str, None] = None):
    return {"item_id": item_id, "q": q}

    
@app.post("/metrics/overmortality/by-lifespans")
async def input_request(request: Request):
    data_json = await request.body()
    data = json.loads(data_json)
    
    print(data)
    
    data = CohortLifespans(**data)
    
    
    
    return {"result": overmortality(data.lifespans)}
    
@app.post("/metrics/overmortality/by-graph")
async def input_request(request: Request):
    data_json = await request.body()
    data = json.loads(data_json)
    
    print(type(data_json))
    print(type(data))
#     print(isinstance(data, dict))
# todo handle validation errors

    print(data_json)
    print(data)
    data = Cohort(**data)
         
    return {"result": overmortality(data)}
