from pydantic import BaseModel

class LifespanGraph(BaseModel):
    x: list
    y: list
    n: int

class Cohort(BaseModel):
    species: str
    strain: str
    graph: LifespanGraph
    
class CohortLifespans(BaseModel):
    species: str
    strain: str
    lifespans: list