sql banco de dados:

CREATE TABLE job_positions (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE people (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE job_history (
    id SERIAL PRIMARY KEY,
    person_id INTEGER NOT NULL,
    job_position_id INTEGER NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    CONSTRAINT fk_person FOREIGN KEY (person_id) REFERENCES people(id) ON DELETE CASCADE,
    CONSTRAINT fk_job_position FOREIGN KEY (job_position_id) REFERENCES job_positions(id) ON DELETE CASCADE
);

CREATE INDEX idx_job_history_person ON job_history(person_id);
CREATE INDEX idx_job_history_position ON job_history(job_position_id);